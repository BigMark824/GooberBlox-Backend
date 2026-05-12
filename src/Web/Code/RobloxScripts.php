<?php

namespace GooberBlox\Web\Code;

use GooberBlox\Web\Code\StaticBundleUtils;

use Wikimedia\Minify\JavaScriptMinifier; // beautiful library
class CdnLibrary
{
    public string $cdnPath;
    public string $localPath;
    public string $test;

    public function __construct(string $cdnPath, string $localPath, string $test)
    {
        $this->cdnPath = $cdnPath;
        $this->localPath = $localPath;
        $this->test = $test;
    }
}

class RobloxScripts
{
    public static function renderScriptTag(string $rawPath): string
    {
        return "<script type='text/javascript' src='{$rawPath}'></script>";
    }
    public static function renderScriptBundle(string $name, array $files, bool $minifyFiles = false): ?string
    {
        $path = self::bundle($name, $files, $minifyFiles);

        if (!$path) {
            return null;
        }

        return self::renderScriptTag($path);
    }
    private static function minifyJavascript(string $js): string
    {
        return JavaScriptMinifier::minify($js);
    }
    public static function bundle(string $namePrefix, array $files, bool $minifyFiles, string $versionNumber = null): ?string
    {
        try {
            $bundleFileName = $namePrefix . "___" . StaticBundleUtils::computeHashForFiles(
                $files,
                config('gooberblox.web-code.Default.JavascriptBundleSalt')
            );

            if (!blank($versionNumber)) {
                $bundleFileName .= "_" . $versionNumber;
            }

            $outputFileRelativePath = "js/m/" . $bundleFileName . ($minifyFiles ? ".min.js" : ".js");
            $outputFileAbsolutePath = public_path($outputFileRelativePath);

            if (!file_exists($outputFileAbsolutePath)) {
                $buffer = '';
                $buffer .= ";// bundle: {$bundleFileName}\n";
                $buffer .= ";// files: " . implode(', ', array_map(
                    fn ($f) => str_replace(['~/js/', '/js/'], '', $f),
                    $files
                )) . "\n";

                foreach ($files as $relativePath) {
                    $relativePath = str_replace('~/', '', $relativePath);
                    $absolutePath = public_path(ltrim($relativePath, '/'));

                    if (!file_exists($absolutePath)) {
                        continue;
                    }

                    $uncompressedContent = file_get_contents($absolutePath);

                    if ($minifyFiles) {
                        if (str_ends_with($absolutePath, '.min.js')) {
                            $content = $uncompressedContent;
                        } else {
                            $content = self::minifyJavascript($uncompressedContent);
                        }
                    } else {
                        $content = $uncompressedContent;
                    }

                    $buffer .= "\n";
                    $buffer .= ";// " . str_replace(['~/js/', '/js/'], '', $relativePath) . "\n";
                    $buffer .= $content . "\n";
                }

                if (!is_dir(dirname($outputFileAbsolutePath))) {
                    mkdir(dirname($outputFileAbsolutePath), 0777, true);
                }

                file_put_contents($outputFileAbsolutePath, $buffer);
            }

            return '/' . ltrim($outputFileRelativePath, '/');
        } catch (\Throwable $e) {
            report($e);
            return null;
        }
    }

    public static function pageBundleMap(bool $minifyFiles = true): array
    {
        $pagesRoot = public_path('js/compiled/pages');

        if (!is_dir($pagesRoot)) {
            return [];
        }

        $bundles = [];
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($pagesRoot, \FilesystemIterator::SKIP_DOTS)
        );

        foreach ($files as $file) {
            if (!$file->isFile()) {
                continue;
            }

            $absolutePath = $file->getPathname();
            $relativePath = str_replace('\\', '/', substr($absolutePath, strlen($pagesRoot) + 1));

            if (!str_ends_with($relativePath, '.compiled.js')) {
                continue;
            }

            $component = substr($relativePath, 0, -strlen('.compiled.js'));
            $compiledPath = '/js/compiled/pages/' . $relativePath;
            $bundle = self::bundle('PageJS', [$compiledPath], $minifyFiles);

            if ($bundle) {
                $bundles[$component] = $bundle;
            }
        }

        ksort($bundles);

        return $bundles;
    }

    function getCdnScripts(): array
    {
        $request = request();

        if (!$request->attributes->has('cdn_scripts')) {
            $request->attributes->set('cdn_scripts', []);
        }

        return $request->attributes->get('cdn_scripts');
    }
}
