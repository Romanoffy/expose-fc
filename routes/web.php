<?php

use App\Http\Middleware\isAdmin;
use App\Http\Middleware\isLoggedIn;
use App\Http\Middleware\isNotLoggedIn;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\NewsCategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\GalleryPhotoController;
use App\Http\Controllers\TeamsCompetitionsController;
use App\Http\Controllers\MatchesController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PlayerPositionController;
use App\Http\Controllers\StandingsController;
use App\Http\Controllers\PelatihController;
use App\Http\Controllers\LatihanController;
use App\Http\Controllers\MerchandiseController;
use App\Http\Controllers\SejarahController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\MenuCategoryController;
use App\Http\Controllers\MatchGoalController;
use App\Http\Controllers\SiteEventController;
use App\Http\Controllers\ClientTeamsController;
use App\Http\Controllers\HistoryPesananController;
use App\Http\Controllers\TransaksiController;
use App\Models\Transaksi;

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

// Beranda
Route::get('/', [SiteController::class, 'index']);

// Login / Logout
Route::get('/login', [UserController::class, 'login'])->middleware(isNotLoggedIn::class);
Route::get('/verify-email/{id}', [UserController::class, 'verifyEmail'])->name('verify.email');
Route::post('/verify-password/{id}', [UserController::class, 'verifyPasswordConfirm'])->name('verify.password.confirm');
Route::get('/verify-email-done', [UserController::class, 'verifyDone'])->name('verify.email.done');
Route::get('/verify-email-change/{token}', [ProfileController::class, 'verifyEmailChange'])->name('verify.email.change');
Route::post('/user/authenticate', [UserController::class, 'authenticate']);

// Google OAuth Routes
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

// GitHub OAuth Routes (Optional)
Route::get('/auth/github', [GoogleAuthController::class, 'redirect'])->name('auth.github');
Route::get('/auth/github/callback', [GoogleAuthController::class, 'callback']);

//Logout
Route::post('/logout', [UserController::class, 'logout'])->middleware(isNotLoggedIn::class);
Route::get('/logout', [UserController::class, 'logout']);

// Registrasi
Route::get('/registrasi', [UserController::class, 'registrasi'])->middleware(isNotLoggedIn::class);
Route::get('/registrasi-admin', [UserController::class, 'registrasiAdmin'])->middleware(isNotLoggedIn::class);
Route::post('/user/regular', [UserController::class, 'storeRegular']);
Route::post('/user/admin', [UserController::class, 'storeAdmin']);

// =======================================================
// 🌐 FRONTEND / CLIENT ROUTES
// =======================================================


// Merchandise (Toko untuk client)
    Route::get('/merchandise', [MerchandiseController::class, 'merchandisesite'])
        ->name('client.merchandise');

//cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

//checkout
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/buy-now', [CheckoutController::class, 'complete'])->name('checkout.complete');
    Route::post('/checkout/complete', [CheckoutController::class, 'complete'])->name('checkout.complete');
    Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');

//history pesanan
Route::get('/history-pesanan', [HistoryPesananController::class, 'index'])->name('client.histori-pesanan');


// Halaman event untuk client
Route::get('/event', [App\Http\Controllers\SiteEventController::class, 'index'])->name('client.event');

// Halaman teams untuk client
Route::get('/teams', [ClientTeamsController::class, 'index'])->name('client.teams');
Route::get('/teams/{id}', [ClientTeamsController::class, 'show'])->name('client.team.detail');

//Blog
Route::get('/blog', [BlogController::class, 'blogsite']);
Route::get('/detail-blog/{param}', [BlogController::class, 'blogsite_detail']);

// News
Route::get('/news', [NewsController::class, 'newssite']);
Route::get('/detail-news/{param}', [NewsController::class, 'news_detail']);

// Gallery
Route::get('/gallery', [GalleryController::class, 'galleriesite']);
Route::get('/detail-gallery/{id}', [GalleryController::class, 'gallery_detail']);

// videos
Route::get('/videos', [VideoController::class, 'videosite']);
Route::get('/videos/{id}', [VideoController::class, 'videosite_detail']);

// Matches & Players
Route::get('/matches', [MatchesController::class, 'matchsite']);
Route::get('/players', [PlayerController::class, 'playersite']);
Route::get('/contact', [ContactController::class, 'contactsite']);
Route::get('/pelatih', [PelatihController::class, 'pelatihsite']);
Route::get('/sejarah', [SejarahController::class, 'sejarahsite']);

// Profile
// Route::get('/profile-testing', function () {
//     return view('client.our-tournament.profile');
// });

// Standings Routes - Public
Route::get('/standings', [StandingsController::class, 'allStandings'])->name('standings.index');
Route::get('/standings/filter', [StandingsController::class, 'filterStandings'])->name('standings.filter');

// API endpoint for dynamic standings (optional - for future enhancements)
Route::get('/api/standings/{competitionId}', [StandingsController::class, 'getCompetitionStandings'])
    ->name('api.standings.competition');


// Tournament Routes (Public)
Route::get('/our-tournament', [TournamentController::class, 'index'])
    ->name('tournament.index'); // ✅ Tambahkan name ini

Route::get('/our-tournament/filter', [TournamentController::class, 'filterMatches'])
    ->name('tournament.filter');

// Old Modal Route (Keep for backward compatibility or remove if not needed)
Route::get('/our-tournament/{id}', [TournamentController::class, 'getMatchDetailModal'])
    ->name('tournament.match.detail');

Route::post('/our-tournament/close-modal', [TournamentController::class, 'closeModal'])
    ->name('tournament.close-modal');

// New Full Page Route
Route::get('/match/{id}', [TournamentController::class, 'showMatchDetail'])
    ->name('tournament.match.detail.page');
/**
 * ============================================================================
 * API ROUTES - Match Score Real-time (PUBLIC - Tanpa Auth Required)
 * ============================================================================
 */
Route::get('/api/match/{matchId}/score', [MatchGoalController::class, 'getMatchScore'])->name('api.match.score');
Route::get('/api/match/{matchId}/goals', [MatchGoalController::class, 'getMatchScore'])->name('api.match.goals');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/logout', [UserController::class, 'logout']);

/**
 * ============================================================================
 * ADMIN ROUTES - Middleware isAdmin Required
 * ============================================================================
 */
Route::group(['prefix' => '/admin', 'middleware' => isAdmin::class], function () {

    Route::get('/standings/download_template', [StandingsController::class, 'download_template']);

    // Upload Image Routes for WYSIWYG Editors
    Route::post('blogs/upload-image', [BlogController::class, 'uploadImage']);
    Route::post('news/upload-image', [NewsController::class, 'uploadImage']);

    // Resource Routes
    Route::resources([
        'blogs' => BlogController::class,
        'players' => PlayerController::class,
        'teams' => TeamsController::class,
        'videos' => VideoController::class,
        'positions' => PositionController::class,
        'venues' => VenueController::class,
        'news_categories' => NewsCategoryController::class,
        'contacts' => ContactController::class,
        'match_goals' => MatchGoalController::class,
        'events' => EventController::class,
        'competitions' => CompetitionController::class,
        'matches' => MatchesController::class,
        'news' => NewsController::class,
        'players_positions' => PlayerPositionController::class,
        'teams_competitions' => TeamsCompetitionsController::class,
        'standings' => StandingsController::class,
        'users' => UserController::class,
        'pelatih' => PelatihController::class,
        'latihan' => LatihanController::class,
        'sejarah' => SejarahController::class,
        'merchandise' => MerchandiseController::class,
        'menu-categories' => MenuCategoryController::class,
        'transaksi' => TransaksiController::class,
    ]);

    // Additional Video Routes
    Route::post('/videos/sync-youtube', [VideoController::class, 'syncYouTube'])->name('videos.sync');
    Route::post('/videos/delete-multiple', [VideoController::class, 'deleteMultiple'])->name('videos.delete-multiple');

    // User Status Update
    Route::put('/users/{id}', [UserController::class, 'update'])->name('update-status');

    Route::resource('slider', SliderController::class)->names('admin.slider');
    Route::resource('gallery', GalleryController::class);

    // AJAX CRUD MATCHES
    Route::get('/matches/get-teams/{competitionId}', [MatchesController::class, 'getTeamsByCompetition'])
        ->name('matches.get-teams');


    Route::post('gallery/{gallery}/photos', [GalleryPhotoController::class, 'store'])->name('gallery-photo.store');
    Route::put('gallery/{gallery}/photos/{photo}', [GalleryPhotoController::class, 'update'])->name('gallery-photo.update');
    Route::delete('gallery/{gallery}/photos/{photo}', [GalleryPhotoController::class, 'destroy'])->name('gallery-photo.destroy');
});