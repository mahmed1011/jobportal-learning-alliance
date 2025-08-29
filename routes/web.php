<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CampusController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\EmploymentTypeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('admin/login', [AdminController::class, 'LoginForm'])->name('login');
Route::post('admin/login', [AdminController::class, 'login'])->name('login.submit');


Route::middleware(['auth'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    //All Departments
    Route::resource('departments', DepartmentController::class);
    Route::resource('employment-types', EmploymentTypeController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('campuses', CampusController::class);
    Route::resource('jobs', JobController::class);

    //  Route::get('all-departments', [DepartmentController::class, 'index'])->name('departments');
    // Route::post('store-department', [DepartmentController::class, 'store'])->name('department.store');
    // Route::post('update-department/{id}', [DepartmentController::class, 'update'])->name('department.update');
    // Route::get('delete-department/{id}', [DepartmentController::class, 'destroy'])->name('department.delete');

    // Index - All Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::get('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');


    //Roles Management
    Route::get('/roles', [RoleController::class, 'index'])->name('roles');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::post('/roles/{id}/update', [RoleController::class, 'update'])->name('roles.update');
    Route::get('/roles/{id}/delete', [RoleController::class, 'destroy'])->name('roles.delete');

    //Permissions Management
    // routes/web.php
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions');
    Route::post('/permissions/store', [PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/permissions/edit/{id}', [PermissionController::class, 'edit'])->name('permissions.edit');
    Route::post('/permissions/update/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::get('/permissions/delete/{id}', [PermissionController::class, 'destroy'])->name('permissions.delete');
});

Route::get('/cache-clear', function () {
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('view:clear');
    Artisan::call('cache:clear');

    return "✅ Cache is cleared";
})->name('cacheclear');


Route::get('/insert-cities', function () {
$cities = [
    ['name' => 'Islamabad'],
    ['name' => 'Karachi'],
    ['name' => 'Lahore'],
    ['name' => 'Abbaspur'],
    ['name' => 'Abbottabad'],
    ['name' => 'Abdul Hakim'],
    ['name' => 'Adda Jahan Khan'],
    ['name' => 'Adda Shaiwala'],
    ['name' => 'Ahmadpur East'],
    ['name' => 'Ahmed pur Sial'],
    ['name' => 'Akhora Khattak'],
    ['name' => 'Ali Chak'],
    ['name' => 'Alipur'],
    ['name' => 'Allahabad'],
    ['name' => 'Amangarh'],
    ['name' => 'Ambela'],
    ['name' => 'Arifwala'],
    ['name' => 'Astore'],
    ['name' => 'Attock'],
    ['name' => 'Babri Banda'],
    ['name' => 'Badin'],
    ['name' => 'Bagh'],
    ['name' => 'Bahawalnagar'],
    ['name' => 'Bahawalpur'],
    ['name' => 'Bajaur'],
    ['name' => 'Balakot'],
    ['name' => 'Bannu'],
    ['name' => 'Barbar Loi'],
    ['name' => 'Barkhan'],
    ['name' => 'Baroute'],
    ['name' => 'Bat Khela'],
    ['name' => 'Battagram'],
    ['name' => 'Besham'],
    ['name' => 'Bewal'],
    ['name' => 'Bhakkar'],
    ['name' => 'Bhalwal'],
    ['name' => 'Bhan Saeedabad'],
    ['name' => 'Bhara Kahu'],
    ['name' => 'Bhera'],
    ['name' => 'Bhimbar'],
    ['name' => 'Bhirya Road'],
    ['name' => 'Bhuawana'],
    ['name' => 'Bisham'],
    ['name' => 'Blitang'],
    ['name' => 'Bolan'],
    ['name' => 'Buchay Key'],
    ['name' => 'Bunner'],
    ['name' => 'Burewala'],
    ['name' => 'Chacklala'],
    ['name' => 'Chaghi'],
    ['name' => 'Chaininda'],
    ['name' => 'Chak 4 b c'],
    ['name' => 'Chak 46'],
    ['name' => 'Chak Jamal'],
    ['name' => 'Chak Jhumra'],
    ['name' => 'Chak Sawara'],
    ['name' => 'Chak Sheza'],
    ['name' => 'Chakwal'],
    ['name' => 'Chaman'],
    ['name' => 'Charsada'],
    ['name' => 'Chashma'],
    ['name' => 'Chawinda'],
    ['name' => 'Cherat'],
    ['name' => 'Chicha watni'],
    ['name' => 'Chilas'],
    ['name' => 'Chiniot'],
    ['name' => 'Chishtian'],
    ['name' => 'Chitral'],
    ['name' => 'Choa Saiden Shah'],
    ['name' => 'Chohar Jamali'],
    ['name' => 'Choppar Hatta'],
    ['name' => 'Chowk Azam'],
    ['name' => 'Chowk Maitla'],
    ['name' => 'Chowk Munda'],
    ['name' => 'Chunian'],
    ['name' => 'Dadakhel'],
    ['name' => 'Dadu'],
    ['name' => 'Daharki'],
    ['name' => 'Dandot'],
    ['name' => 'Dargai'],
    ['name' => 'Darra Pezu'],
    ['name' => 'Darya Khan'],
    ['name' => 'Daska'],
    ['name' => 'Dassu'],
    ['name' => 'Daud Khel'],
    ['name' => 'Daulat Pur'],
    ['name' => 'Daur'],
    ['name' => 'Deh Pathaan'],
    ['name' => 'Depal Pur'],
    ['name' => 'Dera Bugti'],
    ['name' => 'Dera Ghazi Khan'],
    ['name' => 'Dera Ismail Khan'],
    ['name' => 'Dera Murad Jamali'],
    ['name' => 'Dera Nawab Sahib'],
    ['name' => 'Dhatmal'],
    ['name' => 'Dhirkot'],
    ['name' => 'Dhoun Kal'],
    ['name' => 'Diamer'],
    ['name' => 'Digri'],
    ['name' => 'Dijkot'],
    ['name' => 'Dina'],
    ['name' => 'Dinga'],
    ['name' => 'Dir'],
    ['name' => 'Doaaba'],
    ['name' => 'Doltala'],
    ['name' => 'Domeli'],
    ['name' => 'Dudial'],
    ['name' => 'Dunyapur'],
    ['name' => 'Eminabad'],
    ['name' => 'Faisalabad'],
    ['name' => 'Farooqabad'],
    ['name' => 'Fateh Jang'],
    ['name' => 'Fateh Pur'],
    ['name' => 'Feroz Walla'],
    ['name' => 'Feroz Watan'],
    ['name' => 'Fizagat'],
    ['name' => 'Fort Abbas'],
    ['name' => 'FR Bannu'],
    ['name' => 'FR DI Khan'],
    ['name' => 'FR Kohat'],
    ['name' => 'FR Peshawar'],
    ['name' => 'FR Tank / DI Khan'],
    ['name' => 'Gadoon Amazai'],
    ['name' => 'Gaggo Mandi'],
    ['name' => 'Gakhar Mandi'],
    ['name' => 'Gambet'],
    ['name' => 'Garh Maharaja'],
    ['name' => 'Garh More'],
    ['name' => 'Gari Habibullah'],
    ['name' => 'Gari Mori'],
    ['name' => 'Ghari Dupatta'],
    ['name' => 'Gharo'],
    ['name' => 'Ghazi'],
    ['name' => 'Ghizer'],
    ['name' => 'Ghotki'],
    ['name' => 'Ghuzdar'],
    ['name' => 'Gilgit'],
    ['name' => 'Gohar Ghoushti'],
    ['name' => 'Gojra'],
    ['name' => 'Goular Khel'],
    ['name' => 'Guddu'],
    ['name' => 'Gujar Khan'],
    ['name' => 'Gujranwala'],
    ['name' => 'Gujrat'],
    ['name' => 'Gwadar'],
    ['name' => 'Hafizabad'],
    ['name' => 'Hala'],
    ['name' => 'Hangu'],
    ['name' => 'Hari Pur'],
    ['name' => 'Harnai'],
    ['name' => 'Haroonabad'],
    ['name' => 'Hasilpur'],
    ['name' => 'Hassan Abdal'],
    ['name' => 'Hattar'],
    ['name' => 'Haveli Lakha'],
    ['name' => 'Havelian'],
    ['name' => 'Hayatabad'],
    ['name' => 'Hazro'],
    ['name' => 'Hub Chowki'],
    ['name' => 'Hunza Nagar'],
    ['name' => 'Hyderabad'],
    ['name' => 'Jacobabad'],
    ['name' => 'Jaffarabad'],
    ['name' => 'Jalal Pur Jatan'],
    ['name' => 'Jampur'],
    ['name' => 'Jamshoro'],
    ['name' => 'Jaranwala'],
    ['name' => 'Jatoi'],
    ['name' => 'Jauharabad'],
    ['name' => 'Jehangira'],
    ['name' => 'Jhang'],
    ['name' => 'Jhelum'],
    ['name' => 'Jhudo'],
    ['name' => 'Kabir Wala'],
    ['name' => 'Kahuta'],
    ['name' => 'Kala Shah Kaku'],
    ['name' => 'Kalat'],
    ['name' => 'Kamalia'],
    ['name' => 'Kamoke'],
    ['name' => 'Kamra'],
    ['name' => 'Kandhkot'],
    ['name' => 'Kandiaro'],
    ['name' => 'Karak'],
    ['name' => 'Kasur'],
    ['name' => 'Kech'],
    ['name' => 'Khairpur'],
    ['name' => 'Khanewal'],
    ['name' => 'Khanpur'],
    ['name' => 'Kharan'],
    ['name' => 'Kharian'],
    ['name' => 'Khushab'],
    ['name' => 'Khuzdar'],
    ['name' => 'Kohat'],
    ['name' => 'Kohlu'],
    ['name' => 'Kot Addu'],
    ['name' => 'Kotli'],
    ['name' => 'Kotmomin'],
    ['name' => 'Kotri'],
    ['name' => 'Kundian'],
    ['name' => 'Lahore'],
    ['name' => 'Lakki Marwat'],
    ['name' => 'Lala Musa'],
    ['name' => 'Larkana'],
    ['name' => 'Lasbela'],
    ['name' => 'Layyah'],
    ['name' => 'Lodhran'],
    ['name' => 'Loralai'],
    ['name' => 'Mailsi'],
    ['name' => 'Mandi Bahauddin'],
    ['name' => 'Mansehra'],
    ['name' => 'Mardan'],
    ['name' => 'Matiari'],
    ['name' => 'Mehar'],
    ['name' => 'Mian Channu'],
    ['name' => 'Mianwali'],
    ['name' => 'Mingora'],
    ['name' => 'Mirpur'],
    ['name' => 'Mirpur Khas'],
    ['name' => 'Multan'],
    ['name' => 'Muzaffarabad'],
    ['name' => 'Muzaffargarh'],
    ['name' => 'Nankana Sahib'],
    ['name' => 'Narowal'],
    ['name' => 'Nawabshah'],
    ['name' => 'Neelum'],
    ['name' => 'Nowshera'],
    ['name' => 'Okara'],
    ['name' => 'Pakpattan'],
    ['name' => 'Panjgur'],
    ['name' => 'Parachinar'],
    ['name' => 'Pasni'],
    ['name' => 'Peshawar'],
    ['name' => 'Pishin'],
    ['name' => 'Qambar'],
    ['name' => 'Quetta'],
    ['name' => 'Rahim Yar Khan'],
    ['name' => 'Rajanpur'],
    ['name' => 'Rawalpindi'],
    ['name' => 'Sadiqabad'],
    ['name' => 'Sahiwal'],
    ['name' => 'Sanghar'],
    ['name' => 'Sargodha'],
    ['name' => 'Shahdadpur'],
    ['name' => 'Sheikhupura'],
    ['name' => 'Shikarpur'],
    ['name' => 'Sialkot'],
    ['name' => 'Sibi'],
    ['name' => 'Skardu'],
    ['name' => 'Sukkur'],
    ['name' => 'Swabi'],
    ['name' => 'Swat'],
    ['name' => 'Tando Adam'],
    ['name' => 'Tando Allahyar'],
    ['name' => 'Tando Muhammad Khan'],
    ['name' => 'Tank'],
    ['name' => 'Tharparkar'],
    ['name' => 'Thatta'],
    ['name' => 'Toba Tek Singh'],
    ['name' => 'Turbat'],
    ['name' => 'Umerkot'],
    ['name' => 'Vehari'],
    ['name' => 'Wah Cantt'],
    ['name' => 'Warburton'],
    ['name' => 'Wazirabad'],
    ['name' => 'Zhob'],
    ['name' => 'Ziarat'],
];

    DB::table('cities')->insert($cities);

    return "✅ Cities inserted successfully!";
});
