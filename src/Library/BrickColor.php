<?php

namespace GooberBlox\Library;

final class BrickColor
{
    public int $id;
    public string $name;
    public array $color; 

    private static array $colors = [];
    private static array $primaryColors = [];
    private static array $avatarPageAdvancedColorPalette = [];
    private static array $avatarPageBasicColorPalette = [];
    private static array $avatarValidColors = [];
    private static array $lookupById = [];
    private static array $lookupByName = [];
    private static bool $initialized = false;

    public function __construct(int $id, string $name, int $r, int $g, int $b)
    {
        $this->id = $id;
        $this->name = $name;
        $this->color = [$r, $g, $b];
    }

    private static function init(): void
    {
        if (self::$initialized) {
            return;
        }

        $colorsData = [
            [1, "White", 242, 243, 243],
            [208, "Light stone grey", 229, 228, 223],
            [194, "Medium stone grey", 163, 162, 165],
            [199, "Dark stone grey", 99, 95, 98],
            [26, "Black", 27, 42, 53],
            [21, "Bright red", 196, 40, 28],
            [24, "Bright yellow", 245, 205, 48],
            [226, "Cool yellow", 253, 234, 141],
            [23, "Bright blue", 13, 105, 172],
            [107, "Bright bluish green", 0, 143, 156],
            [102, "Medium blue", 110, 153, 202],
            [11, "Pastel Blue", 128, 187, 220],
            [45, "Light blue", 180, 210, 228],
            [135, "Sand blue", 116, 134, 157],
            [106, "Bright orange", 218, 133, 65],
            [105, "Br. yellowish orange", 226, 155, 64],
            [141, "Earth green", 39, 70, 45],
            [28, "Dark green", 40, 127, 71],
            [37, "Bright green", 75, 151, 75],
            [119, "Br. yellowish green", 164, 189, 71],
            [29, "Medium green", 161, 196, 140],
            [151, "Sand green", 120, 144, 130],
            [38, "Dark orange", 160, 95, 53],
            [192, "Reddish brown", 105, 64, 40],
            [104, "Bright violet", 107, 50, 124],
            [9, "Light reddish violet", 232, 186, 200],
            [101, "Medium red", 218, 134, 122],
            [5, "Brick yellow", 215, 197, 154],
            [153, "Sand red", 149, 121, 119],
            [217, "Brown", 124, 92, 70],
            [18, "Nougat", 204, 142, 105],
            [125, "Light orange", 234, 184, 146],
            [1001, "Institutional white", 248, 248, 248],
            [1002, "Mid gray", 205, 205, 205],
            [1003, "Really black", 17, 17, 17],
            [1022, "Grime", 127, 142, 100],
            [1023, "Lavender", 140, 91, 159],
            [133, "Neon orange", 213, 115, 61],
            [1018, "Teal", 18, 238, 212],
            [1030, "Pastel brown", 255, 204, 153],
            [1029, "Pastel yellow", 255, 255, 204],
            [1025, "Pastel orange", 255, 201, 201],
            [1016, "Pink", 255, 102, 204],
            [1026, "Pastel violet", 177, 167, 255],
            [1024, "Pastel light blue", 175, 221, 255],
            [1027, "Pastel blue-green", 159, 243, 233],
            [1028, "Pastel green", 204, 255, 204],
            [1008, "Olive", 193, 190, 66],
            [1009, "New Yeller", 255, 255, 0],
            [1017, "Deep orange", 255, 175, 0],
            [1005, "Deep orange", 255, 175, 0],
            [1004, "Really red", 255, 0, 0],
            [1032, "Hot pink", 255, 0, 191],
            [1010, "Really blue", 0, 0, 255],
            [1019, "Toothpaste", 0, 255, 255],
            [1020, "Lime green", 0, 255, 0],
            [1031, "Royal purple", 98, 37, 209],
            [1006, "Alder", 180, 128, 255],
            [1013, "Cyan", 4, 175, 236],
            [1021, "Camo", 58, 125, 21],
            [1014, "CGA brown", 170, 85, 0],
            [1007, "Dusty Rose", 163, 75, 75],
            [1015, "Magenta", 170, 0, 170],
            [1012, "Deep blue", 33, 84, 185],
            [1011, "Navy blue", 0, 32, 96],
            [301, "Slime green", 80, 109, 84],
            [303, "Dark blue", 0, 16, 176],
            [304, "Parsley green", 44, 101, 29],
            [302, "Smoky grey", 91, 93, 105],
            [305, "Steel blue", 82, 124, 174],
            [306, "Storm blue", 51, 88, 130],
            [307, "Lapis", 16, 42, 220],
            [308, "Dark indigo", 61, 21, 133],
            [309, "Sea green", 52, 142, 64],
            [310, "Shamrock", 91, 154, 76],
            [312, "Mulberry", 89, 34, 89],
            [313, "Forest green", 31, 128, 29],
            [311, "Fossil", 159, 161, 172],
            [315, "Electric blue", 9, 137, 207],
            [316, "Eggplant", 123, 0, 123],
            [317, "Moss", 124, 156, 107],
            [318, "Artichoke", 138, 171, 133],
            [319, "Sage green", 185, 196, 177],
            [314, "Cadet blue", 159, 173, 192],
            [321, "Lilac", 167, 94, 155],
            [322, "Plum", 123, 47, 123],
            [323, "Olivine", 148, 190, 129],
            [324, "Laurel green", 168, 189, 153],
            [325, "Quill grey", 223, 223, 222],
            [320, "Ghost grey", 202, 203, 209],
            [327, "Crimson", 151, 0, 0],
            [328, "Mint", 177, 229, 166],
            [329, "Baby blue", 152, 194, 219],
            [330, "Carnation pink", 255, 152, 220],
            [331, "Persimmon", 255, 89, 89],
            [332, "Maroon", 117, 0, 0],
            [333, "Gold", 239, 184, 56],
            [334, "Daisy orange", 248, 217, 109],
            [335, "Pearl", 231, 231, 236],
            [336, "Fog", 199, 212, 228],
            [342, "Mauve", 224, 178, 208],
            [343, "Sunrise", 212, 144, 189],
            [338, "Terra Cotta", 190, 104, 98],
            [339, "Cocoa", 86, 36, 36],
            [340, "Wheat", 241, 231, 199],
            [341, "Buttermilk", 254, 243, 187],
            [337, "Salmon", 255, 148, 148],
            [344, "Tawny", 150, 85, 85],
            [345, "Rust", 143, 76, 42],
            [346, "Cashmere", 211, 190, 150],
            [347, "Khaki", 226, 220, 188],
            [348, "Lily white", 237, 234, 234],
            [349, "Seashell", 233, 218, 218],
            [350, "Burgundy", 136, 62, 62],
            [351, "Cork", 188, 155, 93],
            [352, "Burlap", 199, 172, 120],
            [353, "Beige", 202, 191, 163],
            [354, "Oyster", 187, 179, 178],
            [355, "Pine Cone", 108, 88, 75],
            [356, "Fawn brown", 160, 132, 79],
            [357, "Hurricane grey", 149, 137, 136],
            [358, "Cloudy grey", 171, 168, 158],
            [359, "Linen", 175, 148, 131],
            [360, "Copper", 150, 103, 102],
            [361, "Dirt brown", 86, 66, 54],
            [362, "Bronze", 126, 104, 63],
            [363, "Flint", 105, 102, 92],
            [364, "Dark taupe", 90, 76, 66],
            [365, "Burnt Sienna", 106, 57, 9],
        ];

        foreach ($colorsData as $c) {
            $color = new BrickColor($c[0], $c[1], $c[2], $c[3], $c[4]);
            self::$colors[] = $color;
            self::$lookupById[$color->id] = $color;
            self::$lookupByName[$color->name] = $color;
        }

        self::$primaryColors = [
            self::$lookupById[1],
            self::$lookupById[208],
            self::$lookupById[199],
            self::$lookupById[26],
            self::$lookupById[21],
            self::$lookupById[24],
            self::$lookupById[23],
            self::$lookupById[102],
            self::$lookupById[141],
            self::$lookupById[37],
            self::$lookupById[29],
        ];

        self::$avatarPageAdvancedColorPalette = [
            self::$lookupById[361],
            self::$lookupById[192],
            self::$lookupById[217],
            self::$lookupById[153],
            self::$lookupById[359],
            self::$lookupById[352],
            self::$lookupById[5],
            self::$lookupById[101],
            self::$lookupById[1007],
            self::$lookupById[1014],
            self::$lookupById[38],
            self::$lookupById[18],
            self::$lookupById[125],
            self::$lookupById[1030],
            self::$lookupById[133],
            self::$lookupById[106],
            self::$lookupById[105],
            self::$lookupById[1017],
            self::$lookupById[24],
            self::$lookupById[334],
            self::$lookupById[226],
            self::$lookupById[141],
            self::$lookupById[1021],
            self::$lookupById[28],
            self::$lookupById[37],
            self::$lookupById[310],
            self::$lookupById[317],
            self::$lookupById[119],
            self::$lookupById[1011],
            self::$lookupById[1012],
            self::$lookupById[1010],
            self::$lookupById[23],
            self::$lookupById[305],
            self::$lookupById[102],
            self::$lookupById[45],
            self::$lookupById[107],
            self::$lookupById[1018],
            self::$lookupById[1027],
            self::$lookupById[1019],
            self::$lookupById[1013],
            self::$lookupById[11],
            self::$lookupById[1024],
            self::$lookupById[104],
            self::$lookupById[1023],
            self::$lookupById[321],
            self::$lookupById[1015],
            self::$lookupById[1031],
            self::$lookupById[1006],
            self::$lookupById[1026],
            self::$lookupById[21],
            self::$lookupById[1004],
            self::$lookupById[1032],
            self::$lookupById[1016],
            self::$lookupById[330],
            self::$lookupById[9],
            self::$lookupById[1025],
            self::$lookupById[364],
            self::$lookupById[351],
            self::$lookupById[1008],
            self::$lookupById[29],
            self::$lookupById[1022],
            self::$lookupById[151],
            self::$lookupById[135],
            self::$lookupById[1020],
            self::$lookupById[1028],
            self::$lookupById[1009],
            self::$lookupById[1029],
            self::$lookupById[1003],
            self::$lookupById[26],
            self::$lookupById[199],
            self::$lookupById[194],
            self::$lookupById[1002],
            self::$lookupById[208],
            self::$lookupById[1],
            self::$lookupById[1001],
        ];

        self::$avatarValidColors = array_merge(
            self::$avatarPageAdvancedColorPalette,
            [self::$lookupById[1005]]
        );

        self::$initialized = true;
    }

    public static function getAll(): array
    {
        self::init();
        return self::$colors;
    }

    public static function get(int $id): ?BrickColor
    {
        self::init();
        return self::$lookupById[$id] ?? null;
    }
    
    public static function getByString(string $name): ?BrickColor
    {
        self::init();
        return self::$lookupByName[$name] ?? null;
    }

    public static function getRandom(): BrickColor
    {
        self::init();
        return self::$colors[array_rand(self::$colors)];
    }

    public static function getAllValidColors(): BrickColor
    {
        self::init();
        return self::$avatarValidColors[array_rand(self::$avatarValidColors)];
    }

    public static function default(): BrickColor
    {
        self::init();
        return self::$lookupById[194];
    }
}
