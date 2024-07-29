<?php

namespace Database\Seeders;

use App\Classes\Permissions;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Stichoza\GoogleTranslate\Exceptions\LargeTextException;
use Stichoza\GoogleTranslate\Exceptions\RateLimitException;
use Stichoza\GoogleTranslate\Exceptions\TranslationRequestException;
use Stichoza\GoogleTranslate\GoogleTranslate;

class AdminPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionGroups = Permissions::attributes();
//        $translator = new GoogleTranslate('ar');
//        $translations = [];

        foreach ($permissionGroups as $permissionGroupKey => $permissionGroup) {

//            if (!in_array($permissionGroupKey, $translations)) {
//                $translations[$permissionGroupKey] = $translator->translate($permissionGroupKey);
//            }

            foreach ($permissionGroup as $permission) {
                $sentence = "can $permission $permissionGroupKey";
                Permission::findOrCreate($sentence, "admin");

//                try {
//                    $translations[$sentence] = $translator->translate($sentence);
//                } catch (LargeTextException $e) {
//                } catch (RateLimitException $e) {
//                } catch (TranslationRequestException $e) {
//                }
            }
        }

//        $this->regeneratePermissionsFile($translations);

    }

    public function regeneratePermissionsFile($translations)
    {
        $permissionsFile = base_path('lang/ar/permissions.php');

        // Make sure the directory exists
        if (!is_dir(dirname($permissionsFile))) {
            mkdir(dirname($permissionsFile), 0755, true);
        }

        // Write the translations to the file
        file_put_contents($permissionsFile, '<?php return ' . var_export($translations, true) . ';');
    }
}
