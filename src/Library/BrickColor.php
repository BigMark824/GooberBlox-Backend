<?php

namespace GooberBlox;

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

        self::$colors = [
            new BrickColor(1, "White", 242, 243, 243),
            new BrickColor(208, "Light stone grey", 229, 228, 223),
            new BrickColor(194, "Medium stone grey", 163, 162, 165),
            new BrickColor(199, "Dark stone grey", 99, 95, 98),
            new BrickColor(26, "Black", 27, 42, 53),
            new BrickColor(21, "Bright red", 196, 40, 28),
            new BrickColor(24, "Bright yellow", 245, 205, 48),
            new BrickColor(226, "Cool yellow", 253, 234, 141),
            new BrickColor(23, "Bright blue", 13, 105, 172),
            new BrickColor(107, "Bright bluish green", 0, 143, 156),
            new BrickColor(102, "Medium blue", 110, 153, 202),
            new BrickColor(11, "Pastel Blue", 128, 187, 220),
            new BrickColor(45, "Light blue", 180, 210, 228),
            new BrickColor(135, "Sand blue", 116, 134, 157),
            new BrickColor(106, "Bright orange", 218, 133, 65),
            new BrickColor(105, "Br. yellowish orange", 226, 155, 64),
            new BrickColor(141, "Earth green", 39, 70, 45),
            new BrickColor(28, "Dark green", 40, 127, 71),
            new BrickColor(37, "Bright green", 75, 151, 75),
            new BrickColor(119, "Br. yellowish green", 164, 189, 71),
            new BrickColor(29, "Medium green", 161, 196, 140),
            new BrickColor(151, "Sand green", 120, 144, 130),
            new BrickColor(38, "Dark orange", 160, 95, 53),
            new BrickColor(192, "Reddish brown", 105, 64, 40),
            new BrickColor(104, "Bright violet", 107, 50, 124),
            new BrickColor(9, "Light reddish violet", 232, 186, 200),
            new BrickColor(101, "Medium red", 218, 134, 122),
            new BrickColor(5, "Brick yellow", 215, 197, 154),
            new BrickColor(153, "Sand red", 149, 121, 119),
            new BrickColor(217, "Brown", 124, 92, 70),
            new BrickColor(18, "Nougat", 204, 142, 105),
            new BrickColor(125, "Light orange", 234, 184, 146),
            new BrickColor(1001, "Institutional white", 248, 248, 248),
            new BrickColor(1002, "Mid gray", 205, 205, 205),
            new BrickColor(1003, "Really black", 17, 17, 17),
            new BrickColor(1022, "Grime", 127, 142, 100),
            new BrickColor(1023, "Lavender", 140, 91, 159),
            new BrickColor(133, "Neon orange", 213, 115, 61),
            new BrickColor(1018, "Teal", 18, 238, 212),
            new BrickColor(1030, "Pastel brown", 255, 204, 153),
            new BrickColor(1029, "Pastel yellow", 255, 255, 204),
            new BrickColor(1025, "Pastel orange", 255, 201, 201),
            new BrickColor(1016, "Pink", 255, 102, 204),
            new BrickColor(1026, "Pastel violet", 177, 167, 255),
            new BrickColor(1024, "Pastel light blue", 175, 221, 255),
            new BrickColor(1027, "Pastel blue-green", 159, 243, 233),
            new BrickColor(1028, "Pastel green", 204, 255, 204),
            new BrickColor(1008, "Olive", 193, 190, 66),
            new BrickColor(1009, "New Yeller", 255, 255, 0),
            new BrickColor(1017, "Deep orange", 255, 175, 0),
            new BrickColor(1005, "Deep orange", 255, 175, 0),
            new BrickColor(1004, "Really red", 255, 0, 0),
            new BrickColor(1032, "Hot pink", 255, 0, 191),
            new BrickColor(1010, "Really blue", 0, 0, 255),
            new BrickColor(1019, "Toothpaste", 0, 255, 255),
            new BrickColor(1020, "Lime green", 0, 255, 0),
            new BrickColor(1031, "Royal purple", 98, 37, 209),
            new BrickColor(1006, "Alder", 180, 128, 255),
            new BrickColor(1013, "Cyan", 4, 175, 236),
            new BrickColor(1021, "Camo", 58, 125, 21),
            new BrickColor(1014, "CGA brown", 170, 85, 0),
            new BrickColor(1007, "Dusty Rose", 163, 75, 75),
            new BrickColor(1015, "Magenta", 170, 0, 170),
            new BrickColor(1012, "Deep blue", 33, 84, 185),
            new BrickColor(1011, "Navy blue", 0, 32, 96),
            new BrickColor(301, "Slime green", 80, 109, 84),
            new BrickColor(303, "Dark blue", 0, 16, 176),
            new BrickColor(304, "Parsley green", 44, 101, 29),
            new BrickColor(302, "Smoky grey", 91, 93, 105),
            new BrickColor(305, "Steel blue", 82, 124, 174),
            new BrickColor(306, "Storm blue", 51, 88, 130),
            new BrickColor(307, "Lapis", 16, 42, 220),
            new BrickColor(308, "Dark indigo", 61, 21, 133),
            new BrickColor(309, "Sea green", 52, 142, 64),
            new BrickColor(310, "Shamrock", 91, 154, 76),
            new BrickColor(312, "Mulberry", 89, 34, 89),
            new BrickColor(313, "Forest green", 31, 128, 29),
            new BrickColor(311, "Fossil", 159, 161, 172),
            new BrickColor(315, "Electric blue", 9, 137, 207),
            new BrickColor(316, "Eggplant", 123, 0, 123),
            new BrickColor(317, "Moss", 124, 156, 107),
            new BrickColor(318, "Artichoke", 138, 171, 133),
            new BrickColor(319, "Sage green", 185, 196, 177),
            new BrickColor(314, "Cadet blue", 159, 173, 192),
            new BrickColor(321, "Lilac", 167, 94, 155),
            new BrickColor(322, "Plum", 123, 47, 123),
            new BrickColor(323, "Olivine", 148, 190, 129),
            new BrickColor(324, "Laurel green", 168, 189, 153),
            new BrickColor(325, "Quill grey", 223, 223, 222),
            new BrickColor(320, "Ghost grey", 202, 203, 209),
            new BrickColor(327, "Crimson", 151, 0, 0),
            new BrickColor(328, "Mint", 177, 229, 166),
            new BrickColor(329, "Baby blue", 152, 194, 219),
            new BrickColor(330, "Carnation pink", 255, 152, 220),
            new BrickColor(331, "Persimmon", 255, 89, 89),
            new BrickColor(332, "Maroon", 117, 0, 0),
            new BrickColor(333, "Gold", 239, 184, 56),
            new BrickColor(334, "Daisy orange", 248, 217, 109),
            new BrickColor(335, "Pearl", 231, 231, 236),
            new BrickColor(336, "Fog", 199, 212, 228),
            new BrickColor(342, "Mauve", 224, 178, 208),
            new BrickColor(343, "Sunrise", 212, 144, 189),
            new BrickColor(338, "Terra Cotta", 190, 104, 98),
            new BrickColor(339, "Cocoa", 86, 36, 36),
            new BrickColor(340, "Wheat", 241, 231, 199),
            new BrickColor(341, "Buttermilk", 254, 243, 187),
            new BrickColor(337, "Salmon", 255, 148, 148),
            new BrickColor(344, "Tawny", 150, 85, 85),
            new BrickColor(345, "Rust", 143, 76, 42),
            new BrickColor(346, "Cashmere", 211, 190, 150),
            new BrickColor(347, "Khaki", 226, 220, 188),
            new BrickColor(348, "Lily white", 237, 234, 234),
            new BrickColor(349, "Seashell", 233, 218, 218),
            new BrickColor(350, "Burgundy", 136, 62, 62),
            new BrickColor(351, "Cork", 188, 155, 93),
            new BrickColor(352, "Burlap", 199, 172, 120),
            new BrickColor(353, "Beige", 202, 191, 163),
            new BrickColor(354, "Oyster", 187, 179, 178),
            new BrickColor(355, "Pine Cone", 108, 88, 75),
            new BrickColor(356, "Fawn brown", 160, 132, 79),
            new BrickColor(357, "Hurricane grey", 149, 137, 136),
            new BrickColor(358, "Cloudy grey", 171, 168, 158),
            new BrickColor(359, "Linen", 175, 148, 131),
            new BrickColor(360, "Copper", 150, 103, 102),
            new BrickColor(361, "Dirt brown", 86, 66, 54),
            new BrickColor(362, "Bronze", 126, 104, 63),
            new BrickColor(363, "Flint", 105, 102, 92),
            new BrickColor(364, "Dark taupe", 90, 76, 66),
            new BrickColor(365, "Burnt Sienna", 106, 57, 9),
        ];

        foreach (self::$colors as $color) {
            self::$lookupById[$color->id] = $color;
        }

        self::$primaryColors = [
            self::get(1),
            self::get(208),
            self::get(199),
            self::get(26),
            self::get(21),
            self::get(24),
            self::get(23),
            self::get(102),
            self::get(141),
            self::get(37),
            self::get(29),
        ];
        
        self::$avatarPageAdvancedColorPalette = [
			self::get(361),
			self::get(192),
			self::get(217),
			self::get(153),
			self::get(359),
			self::get(352),
			self::get(5),
			self::get(101),
			self::get(1007),
			self::get(1014),
			self::get(38),
			self::get(18),
			self::get(125),
			self::get(1030),
			self::get(133),
			self::get(106),
			self::get(105),
			self::get(1017),
			self::get(24),
			self::get(334),
			self::get(226),
			self::get(141),
			self::get(1021),
			self::get(28),
			self::get(37),
			self::get(310),
			self::get(317),
			self::get(119),
			self::get(1011),
			self::get(1012),
			self::get(1010),
			self::get(23),
			self::get(305),
			self::get(102),
			self::get(45),
			self::get(107),
			self::get(1018),
			self::get(1027),
			self::get(1019),
			self::get(1013),
			self::get(11),
			self::get(1024),
			self::get(104),
			self::get(1023),
			self::get(321),
			self::get(1015),
			self::get(1031),
			self::get(1006),
			self::get(1026),
			self::get(21),
			self::get(1004),
			self::get(1032),
			self::get(1016),
			self::get(330),
			self::get(9),
			self::get(1025),
			self::get(364),
			self::get(351),
			self::get(1008),
			self::get(29),
			self::get(1022),
			self::get(151),
			self::get(135),
			self::get(1020),
			self::get(1028),
			self::get(1009),
			self::get(1029),
			self::get(1003),
			self::get(26),
			self::get(199),
			self::get(194),
			self::get(1002),
			self::get(208),
			self::get(1),
			self::get(1001)
        ];

        self::$avatarValidColors = array_merge(
            self::$avatarPageAdvancedColorPalette,
            [self::get(1005)]
        );


        self::$initialized = true;
    }

    public static function get(int $id): ?BrickColor
    {
        self::init();
        return self::$lookupById[$id] ?? null;
    }

    public static function getRandom(): BrickColor
    {
        self::init();
        return self::$colors[array_rand(self::$colors)];
    }

    /// Valid BodyColors
    public static function getAllValidColors(): BrickColor
    {
        self::init();
        return self::$colors[array_rand(self::$primaryColors)];
    }

    public static function default(): BrickColor
    {
        return self::get(194);
    }
}
