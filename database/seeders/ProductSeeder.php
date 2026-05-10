<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::with('subcategories')->get();

        $productNames = [
            // Skin Care
            'Moisturizer' => ['HydraBloom', 'GlowMist', 'VelvetDew', 'AquaLuxe', 'SilkHydrate', 'MoistureMax', 'LumiSoft', 'NourishEssence'],
            'Sunscreen' => ['SunShield', 'UVGuard', 'SolarDefense', 'RadiantBlock', 'SunSafe', 'GlowSPF', 'SunArmor', 'SolarGlow'],
            'Serum' => ['BrightEssence', 'YouthElixir', 'HydraSerum', 'SkinRevive', 'RadianceBoost', 'GlowPotion', 'RenewalDrop', 'LuminousSerum'],
            'Cleanser' => ['PureWash', 'FreshFoam', 'ClearGlow', 'GentleClean', 'HydraWash', 'SoftPurify', 'DailyCleanse', 'BrightFace'],
            'Toner' => ['BalanceMist', 'GlowToner', 'HydraTone', 'FreshBalance', 'RadiantTone', 'ClearTone', 'SkinRefresh', 'SoftTone'],
            'Face Oil' => ['NourishOil', 'GlowDrop', 'HydraOil', 'RadianceOil', 'SilkOil', 'SoftGlow', 'SkinElixir', 'VitalOil'],
            'Face Mist' => ['RefreshMist', 'GlowSpray', 'HydraMist', 'LuminousSpray', 'SkinMist', 'RadiantSpray', 'SoftMist', 'VitalMist'],
            'Exfoliator' => ['SmoothScrub', 'GlowExfol', 'RenewScrub', 'SilkScrub', 'FreshExfol', 'HydraScrub', 'RadianceScrub', 'SoftExfol'],

            // Eyes
            'Eyeliner' => ['PrecisionLine', 'BoldStroke', 'LinerMax', 'EyeDefiner', 'UltraLine', 'SmoothEdge', 'SharpLiner', 'IntenseLine'],
            'Mascara' => ['LashBoost', 'VolumeMax', 'CurlLash', 'LengthenLash', 'MegaLash', 'LashDefine', 'BlackLash', 'LongLash'],
            'Eye Shadow' => ['ColorPop', 'GlowShade', 'LuminousHue', 'VividEyes', 'RadiantShade', 'SoftBlend', 'ShadeArt', 'EyeLuxe'],
            'Eyebrow Pencil' => ['BrowDefine', 'PerfectArch', 'SharpBrow', 'BrowSculpt', 'ArchMaster', 'BrowBoost', 'FineLineBrow', 'NaturalBrow'],
            'Eye Cream' => ['BrightEye', 'HydraEye', 'LumiEye', 'FreshEyes', 'RenewEye', 'SoftEye', 'GlowEye', 'VitalEye'],
            'Eye Gel' => ['CoolEyes', 'HydraGel', 'FreshGel', 'BrightEyes', 'LumiGel', 'SoftGel', 'RadiantGel', 'EyeRevive'],
            'Eyelash Serum' => ['LashGrowth', 'BoostLash', 'LongLash', 'LashElixir', 'EyeLashPro', 'ReviveLash', 'LashMagic', 'VitalLash'],
            'Eye Primer' => ['SmoothBase', 'EyePrep', 'LumiBase', 'PrimeEyes', 'RadiantBase', 'SoftPrimer', 'GlowBase', 'EyeEnhance'],

            // Lips
            'Lipstick' => ['VelvetLip', 'GlowLip', 'ColorLux', 'SoftTint', 'LumiLip', 'RadiantLip', 'SilkLip', 'BoldTint'],
            'Lip Gloss' => ['ShineGloss', 'LumiGloss', 'GlowGloss', 'SoftGloss', 'RadiantGloss', 'GlossMax', 'GlossyKiss', 'SilkGloss'],
            'Lip Balm' => ['HydraBalm', 'SoftBalm', 'NourishLip', 'GlowBalm', 'LumiBalm', 'SilkBalm', 'VitalBalm', 'ComfortLip'],
            'Lip Liner' => ['DefineLip', 'SharpLiner', 'LumiLine', 'PrecisionLip', 'BrowLine', 'SmoothLiner', 'LipEdge', 'ContourLip'],
            'Lip Stain' => ['LongTint', 'GlowStain', 'RadiantTint', 'SoftStain', 'LumiStain', 'VelvetStain', 'BoldTint', 'SilkStain'],
            'Lip Scrub' => ['SmoothScrub', 'GlowScrub', 'SoftExfol', 'HydraScrub', 'LumiScrub', 'VitalScrub', 'RadiantScrub', 'SilkScrub'],
            'Lip Primer' => ['SoftBase', 'LumiPrimer', 'GlowBase', 'HydraPrimer', 'SilkBase', 'RadiantPrimer', 'PrepLip', 'SmoothBase'],
            'Lip Plumper' => ['FullLip', 'GlowPlump', 'LumiPlump', 'SoftPlump', 'HydraPlump', 'RadiantPlump', 'VoluLip', 'PlumpMax'],

            // Nails
            'Nail Polish' => ['ColorSplash', 'ShinyTip', 'GlowNail', 'VelvetNail', 'RadiantPolish', 'LumiNail', 'SilkNail', 'VividPolish'],
            'Nail Care' => ['StrengthNail', 'HydraNail', 'SoftNail', 'NailEssence', 'NourishNail', 'VitalNail', 'GlowNailCare', 'LumiNailCare'],
            'Nail Tools' => ['NailBrush', 'CuticleTool', 'PolishKit', 'FileMaster', 'LumiTools', 'NailPro', 'GroomKit', 'NailSet'],
            'Nail Art' => ['ArtisticTips', 'GlowArt', 'VividNails', 'DesignPolish', 'LumiArt', 'CreativeNails', 'SilkDesign', 'NailDesign'],
            'Cuticle Oil' => ['HydraCuticle', 'NourishOil', 'SoftOil', 'GlowCuticle', 'LumiOil', 'VitalOil', 'SilkCuticle', 'RadiantOil'],
            'Nail Strengthener' => ['StrongNail', 'MaxStrength', 'NailPower', 'HydraStrength', 'VitalNail', 'LumiStrength', 'SilkStrength', 'RadiantNail'],
            'Base Coat' => ['SmoothBase', 'PolishBase', 'LumiBase', 'GlowBase', 'SoftBase', 'HydraBase', 'SilkBase', 'RadiantBase'],
            'Top Coat' => ['ShineTop', 'GlossTop', 'LumiTop', 'GlowTop', 'SilkTop', 'RadiantTop', 'SoftTop', 'HydraTop'],

            // Hair
            'Shampoo' => ['SilkWash', 'HydraShine', 'GlowWash', 'LuxeShampoo', 'SoftStrand', 'RadiantWash', 'VitalShampoo', 'LumiWash'],
            'Conditioner' => ['SilkCondition', 'HydraSoft', 'GlowCondition', 'LuxeConditioner', 'SmoothStrand', 'RadiantCondition', 'VitalCondition', 'LumiCondition'],
            'Hair Oil' => ['NourishOil', 'GlowOil', 'VitalStrand', 'SilkOil', 'HydraOil', 'LuxeOil', 'RadiantOil', 'LumiOil'],
            'Hair Serum' => ['ShineSerum', 'GlowSerum', 'LuxeSerum', 'SilkSerum', 'VitalSerum', 'HydraSerum', 'RadiantSerum', 'LumiSerum'],
            'Hair Mask' => ['RepairMask', 'HydraMask', 'SilkMask', 'GlowMask', 'VitalMask', 'LuxeMask', 'RadiantMask', 'LumiMask'],
            'Hair Spray' => ['HoldSpray', 'SilkSpray', 'HydraSpray', 'GlowSpray', 'VitalSpray', 'LuxeSpray', 'RadiantSpray', 'LumiSpray'],
            'Hair Mousse' => ['VolumeMousse', 'SilkMousse', 'GlowMousse', 'HydraMousse', 'VitalMousse', 'LuxeMousse', 'RadiantMousse', 'LumiMousse'],
            'Hair Gel' => ['HoldGel', 'SilkGel', 'GlowGel', 'HydraGel', 'VitalGel', 'LuxeGel', 'RadiantGel', 'LumiGel'],

            // Perfume
            'Eau de Parfum' => ['Mystique', 'AuraEssence', 'LuxeScent', 'RadiantPerfume', 'GlowMist', 'VelvetAroma', 'SilkFragrance', 'LumiPerfume'],
            'Eau de Toilette' => ['FreshAura', 'GlowToilette', 'SilkMist', 'LumiToilette', 'SoftScent', 'VitalMist', 'RadiantAura', 'LuxeToilette'],
            'Body Mist' => ['GlowBody', 'SilkMist', 'RadiantSpray', 'LumiBody', 'VitalMist', 'SoftSpray', 'FreshMist', 'VelvetMist'],
            'Roll-on' => ['AromaRoll', 'GlowRoll', 'LuxeRoll', 'SilkRoll', 'VitalRoll', 'LumiRoll', 'SoftRoll', 'RadiantRoll'],
            'Perfume Oil' => ['EssenceOil', 'GlowOil', 'SilkOil', 'VitalOil', 'RadiantOil', 'LuxeOil', 'LumiOil', 'SoftOil'],
            'Attar' => ['RoyalAttar', 'GlowAttar', 'SilkAttar', 'VitalAttar', 'LumiAttar', 'RadiantAttar', 'SoftAttar', 'LuxeAttar'],
            'Solid Perfume' => ['GlowSolid', 'SilkSolid', 'VitalSolid', 'LumiSolid', 'RadiantSolid', 'SoftSolid', 'LuxeSolid', 'AuraSolid'],
            'Scented Candle' => ['GlowCandle', 'SilkCandle', 'LumiCandle', 'VitalCandle', 'RadiantCandle', 'SoftCandle', 'LuxeCandle', 'AuraCandle'],

            // Tools
            'Brushes' => ['ProBrush', 'SilkBrush', 'GlowBrush', 'LumiBrush', 'VitalBrush', 'RadiantBrush', 'SoftBrush', 'LuxeBrush'],
            'Applicators' => ['SoftApply', 'GlowApply', 'SilkApplicator', 'LumiApply', 'VitalApplicator', 'RadiantApply', 'LuxeApply', 'ProApply'],
            'Sponges' => ['GlowSponge', 'SilkSponge', 'LumiSponge', 'VitalSponge', 'RadiantSponge', 'SoftSponge', 'LuxeSponge', 'ProSponge'],
            'Tweezers' => ['PrecisionPro', 'SilkTweez', 'GlowTweez', 'LumiTweez', 'VitalTweez', 'RadiantTweez', 'SoftTweez', 'LuxeTweez'],
            'Eyelash Curler' => ['ProCurl', 'SilkCurl', 'GlowCurl', 'LumiCurl', 'VitalCurl', 'RadiantCurl', 'SoftCurl', 'LuxeCurl'],
            'Makeup Bag' => ['GlowBag', 'SilkBag', 'LumiBag', 'VitalBag', 'RadiantBag', 'SoftBag', 'LuxeBag', 'ProBag'],
            'Brush Cleaner' => ['CleanPro', 'SilkClean', 'GlowClean', 'LumiClean', 'VitalClean', 'RadiantClean', 'SoftClean', 'LuxeClean'],
            'Blending Brush' => ['BlendPro', 'SilkBlend', 'GlowBlend', 'LumiBlend', 'VitalBlend', 'RadiantBlend', 'SoftBlend', 'LuxeBlend'],

            // Special Treatments
            'Face Masks' => ['GlowMask', 'SilkMask', 'LumiMask', 'VitalMask', 'RadiantMask', 'SoftMask', 'LuxeMask', 'ProMask'],
            'Scrubs' => ['GlowScrub', 'SilkScrub', 'LumiScrub', 'VitalScrub', 'RadiantScrub', 'SoftScrub', 'LuxeScrub', 'ProScrub'],
            'Serums' => ['GlowSerum', 'SilkSerum', 'LumiSerum', 'VitalSerum', 'RadiantSerum', 'SoftSerum', 'LuxeSerum', 'ProSerum'],
            'Peels' => ['GlowPeel', 'SilkPeel', 'LumiPeel', 'VitalPeel', 'RadiantPeel', 'SoftPeel', 'LuxePeel', 'ProPeel'],
            'Anti-Aging' => ['GlowAge', 'SilkAge', 'LumiAge', 'VitalAge', 'RadiantAge', 'SoftAge', 'LuxeAge', 'ProAge'],
            'Brightening' => ['GlowBright', 'SilkBright', 'LumiBright', 'VitalBright', 'RadiantBright', 'SoftBright', 'LuxeBright', 'ProBright'],
            'Detox' => ['GlowDetox', 'SilkDetox', 'LumiDetox', 'VitalDetox', 'RadiantDetox', 'SoftDetox', 'LuxeDetox', 'ProDetox'],
            'Hydrating' => ['GlowHydra', 'SilkHydra', 'LumiHydra', 'VitalHydra', 'RadiantHydra', 'SoftHydra', 'LuxeHydra', 'ProHydra'],
        ];

        foreach ($categories as $category) {
            foreach ($category->subcategories as $sub) {
                $subName = $sub->name;
                if (!isset($productNames[$subName])) {
                    $productNames[$subName] = [];
                    for ($i = 1; $i <= 8; $i++) {
                        $productNames[$subName][] = $subName . ' Product ' . $i;
                    }
                }

                foreach ($productNames[$subName] as $index => $prodName) {
                    Product::updateOrCreate(
                        ['slug' => strtolower(str_replace(' ', '-', $prodName))],
                        [
                            'name' => $prodName,
                            'subcategory_id' => $sub->id,
                            'price' => rand(199, 999),
                            'image' => 'images/products/' 
                                       . strtolower(str_replace(' ', '-', $category->name)) . '/' 
                                       . strtolower(str_replace(' ', '-', $subName)) . '/p' . ($index+1) . '.jpg',
                            'description' => $prodName . ' is a premium ' . $subName . ' product designed for ' . $category->name . '.'
                        ]
                    );
                }
            }
        }
    }
}
