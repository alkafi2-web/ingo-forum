<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Content\AboutusController;
use App\Http\Controllers\Content\BannerController;
use App\Http\Controllers\Content\MediaController;
use App\Http\Controllers\Content\SystemController;
use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Post\CategoryController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Post\SubCategoryController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Content\PageController;
use App\Http\Controllers\FAQs\FAQsController;
use App\Http\Controllers\Frontend\Auth\FrontAuthController;
use App\Http\Controllers\Frontend\Gallery\FrontendGalleryController;
use App\Http\Controllers\Frontend\Member\MemberController;
use App\Http\Middleware\adminMiddleware;
use Illuminate\Support\Facades\Route;
use PhpOffice\PhpSpreadsheet\Calculation\Category;
use App\Http\Controllers\Frontend\Page\PageController as FrontendPageController;
use App\Http\Controllers\Member\MemberController as AdminMemberController;
use App\Http\Controllers\Menu\MenuController;
use App\Http\Controllers\Frontend\Post\PostController as FrontendPostController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Frontend\Publication\FrontnedPublicationController;
use App\Http\Controllers\Publication\PublicationController;

// robot & sitemap 
Route::get('/robots.txt', [RobotsController::class, 'index']);
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

Route::prefix('admin')->group(function () {
    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post('/', [AuthController::class, 'loginPost']);
    Route::middleware(['admin','updateLastActivity'])->group(function () {

        Route::post('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        // Other routes that require authentication

        //user managment start

        Route::get('/create-user', [AuthController::class, 'createUser'])->name('createUser');
        Route::post('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/user-status', [AuthController::class, 'userStatus'])->name('user.status');
        Route::post('/user-edit', [AuthController::class, 'userEdit'])->name('user.edit');
        Route::post('/user-update', [AuthController::class, 'userUpdate'])->name('user.update');
        Route::post('/user-delete', [AuthController::class, 'userDelete'])->name('user.delete');
        Route::get('/user-trash', [AuthController::class, 'trashedUser'])->name('trashedUser');
        Route::post('/user-restore', [AuthController::class, 'userRestore'])->name('user.restore');
        Route::post('/user-per-delete', [AuthController::class, 'userParDelete'])->name('user.par.delete');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        //user managment end

        // menu route start
        Route::prefix('menu')->group(function () {
            Route::get('/', [MenuController::class, 'index'])->name('menu.index');
            // Route for storing the menu
            Route::post('/menu/store', [MenuController::class, 'store'])->name('menu.store');
            Route::get('/get/post-type', [MenuController::class, 'getPostCat'])->name('menu.post.type');
        });

        // page route start
        Route::prefix('page')->group(function () {
            Route::get('/all', [PageController::class, 'index'])->name('admin.page');
            Route::get('/create-new-page', [PageController::class, 'showCreatePage'])->name('admin.page.create');
            Route::get('/update/{page_id}', [PageController::class, 'showUpdatePage'])->name('admin.page.update');

            Route::get('/slug-verify', [PageController::class, 'verifySlug'])->name('slug.verify');
            Route::get('/edit/{id}', [PageController::class, 'edit'])->name('page.edit');
            Route::post('/storeOrupdate-page', [PageController::class, 'storeOrUpdate'])->name('page.storeOrUpdate');
            Route::post('page/toggle-visibility', [PageController::class, 'toggleVisibility'])->name('page.toggleVisibility');
            Route::delete('/admin/content/page', [PageController::class, 'destroy'])->name('page.destroy');

            // Route for getting the page list
            Route::get('/menu/pages', [PageController::class, 'getPages'])->name('menu.pages');
            Route::post('menu/update-order', [MenuController::class, 'updateOrder'])->name('menu.updateOrder');
            Route::post('menu/create-or-remove-submenu', [MenuController::class, 'createOrRemoveSubmenu'])->name('menu.createOrRemoveSubmenu');
            Route::post('menu/toggle-visibility', [MenuController::class, 'toggleVisibility'])->name('menu.toggleVisibility');
            Route::post('menu/delete', [MenuController::class, 'delete'])->name('menu.delete');
            Route::get('menu/edit', [MenuController::class, 'edit'])->name('menu.edit');
            Route::post('menu/update', [MenuController::class, 'update'])->name('menu.update');
        });
        // page route end

        // banner route start
        Route::prefix('banner')->group(function () {
            Route::get('/', [BannerController::class, 'index'])->name('banner');
            Route::post('/create', [BannerController::class, 'bannerCreate'])->name('banner.create');
            Route::post('/delete', [BannerController::class, 'bannerDelete'])->name('banner.delete');
            Route::post('/status', [BannerController::class, 'bannerStatus'])->name('banner.status');
            Route::post('/edit', [BannerController::class, 'bannerEdit'])->name('banner.edit');
            Route::post('/update', [BannerController::class, 'bannerUpdate'])->name('banner.update');
        });
        // banner route end

        // content manegment route start
        Route::prefix('system-content')->group(function () {
            Route::get('/', [SystemController::class, 'index'])->name('system');
            Route::post('/systempost', [SystemController::class, 'systemPost'])->name('system.post');
        });
        // content manegment route end

        // about us-content route start
        Route::prefix('about-us')->group(function () {
            Route::get('/', [AboutusController::class, 'index'])->name('aboutus');
            Route::post('/create', [AboutusController::class, 'aboutusCreate'])->name('aboutus.create');
            Route::post('/content-edit', [AboutusController::class, 'aboutuscontentEdit'])->name('aboutuscontent.edit');
            Route::post('/feature-create', [AboutusController::class, 'aboutusFeatureCreate'])->name('aboutus.feature.create');
            Route::post('/feature-data', [AboutusController::class, 'aboutusFeatureData'])->name('aboutus.feature.data');
            Route::post('/feature-data-delete', [AboutusController::class, 'featureDelete'])->name('feature.delete');
            Route::post('/feature-status', [AboutusController::class, 'featureStatus'])->name('feature.status');
            Route::post('/feature-edit', [AboutusController::class, 'featureEdit'])->name('feature.edit');
            Route::post('/feature-update', [AboutusController::class, 'featureUpdate'])->name('feature.update');
        });
        // about us-content route end
        Route::prefix('faqs')->group(function () {
            Route::get('/', [FAQsController::class, 'index'])->name('faqs');
            Route::post('/create', [FAQsController::class, 'create'])->name('faqs.create');
            Route::post('/edit', [FAQsController::class, 'edit'])->name('faqs.edit');
            Route::post('/delete', [FAQsController::class, 'delete'])->name('faqs.delete');
            Route::post('/status', [FAQsController::class, 'status'])->name('faqs.status');
            Route::post('/update', [FAQsController::class, 'update'])->name('faqs.update');
        });
        // FAQs Route start

        // FAQs Route end

        // post menagement route start
        Route::prefix('post')->group(function () {
            Route::prefix('category')->group(function () {
                Route::get('/', [CategoryController::class, 'category'])->name('category');
                Route::post('/category-create', [CategoryController::class, 'categoryCreate'])->name('category.create');
                Route::post('/category-delete', [CategoryController::class, 'categoryDelete'])->name('category.delete');
                Route::post('/category-status', [CategoryController::class, 'categoryStatus'])->name('category.status');
                Route::post('/category-edit', [CategoryController::class, 'categoryEdit'])->name('category.edit');
                Route::post('/category-update', [CategoryController::class, 'categoryUpdate'])->name('category.update');
            });
            Route::prefix('sub-category')->group(function () {
                Route::get('/', [SubCategoryController::class, 'subcategory'])->name('subcategory');
                Route::post('/sub-category-create', [SubCategoryController::class, 'subcategoryCreate'])->name('subcategory.create');
                Route::post('/sub-category-delete', [SubCategoryController::class, 'subcategoryDelete'])->name('subcategory.delete');
                Route::post('/sub-category-status', [SubCategoryController::class, 'subcategoryStatus'])->name('subcategory.status');
                Route::post('/sub-category-edit', [SubCategoryController::class, 'subcategoryEdit'])->name('subcategory.edit');
                Route::post('/sub-category-update', [SubCategoryController::class, 'subcategoryUpdate'])->name('subcategory.update');
            });
            Route::prefix('/')->group(function () {
                Route::get('/', [PostController::class, 'postCreate'])->name('post.create');
                Route::post('/store', [PostController::class, 'postStore'])->name('post.store');
                Route::get('/list', [PostController::class, 'postList'])->name('post.list');
                Route::post('/delete', [PostController::class, 'postDelete'])->name('post.delete');
                Route::post('/comment', [PostController::class, 'postComment'])->name('post.comment');
                Route::post('/status', [PostController::class, 'postStatus'])->name('post.status');
                Route::get('/edit/{id}', [PostController::class, 'postEdit'])->name('post.edit');
                Route::post('/update', [PostController::class, 'postUpdate'])->name('post.update');
            });
        });
        // post menagement route end

        // Publication menagement route start
        Route::prefix('publication')->group(function () {
            Route::prefix('category')->group(function () {
                Route::get('/', [PublicationController::class, 'category'])->name('publication.category');
                Route::post('/category-create', [PublicationController::class, 'categoryCreate'])->name('publication.category.create');
                Route::post('/category-delete', [PublicationController::class, 'categoryDelete'])->name('publication.category.delete');
                Route::post('/category-status', [PublicationController::class, 'categoryStatus'])->name('publication.category.status');
                Route::post('/category-edit', [PublicationController::class, 'categoryEdit'])->name('publication.category.edit');
                Route::post('/category-update', [PublicationController::class, 'categoryUpdate'])->name('publication.category.update');
            });
            
            Route::prefix('/')->group(function () {
                Route::get('/', [PublicationController::class, 'publicationCreate'])->name('publication.create');
                Route::post('/store', [PublicationController::class, 'publicationStore'])->name('publication.store');
                Route::get('/list', [PublicationController::class, 'publicationList'])->name('publication.list');
                Route::post('/delete', [PublicationController::class, 'publicationDelete'])->name('publication.delete');
                Route::post('/status', [PublicationController::class, 'publicationStatus'])->name('publication.status');
                Route::get('/edit/{id}', [PublicationController::class, 'publicationEdit'])->name('publication.edit');
                Route::post('/update', [PublicationController::class, 'publicationUpdate'])->name('publication.update');
            });
        });
        // Publication menagement route end

        // event managment route start
        Route::prefix('event')->group(function () {
            Route::get('/', [EventController::class, 'event'])->name('event');
            Route::post('/create', [EventController::class, 'eventCreate'])->name('event.create');
            Route::post('/delete', [EventController::class, 'eventDelete'])->name('event.delete');
            Route::post('/status', [EventController::class, 'eventStatus'])->name('event.status');
            Route::post('/edit', [EventController::class, 'eventEdit'])->name('event.edit');
            Route::post('/update', [EventController::class, 'eventUpdate'])->name('event.update');
        });
        // event managment route end

        // role route start
        Route::prefix('role')->group(function () {
            Route::get('/', [RoleController::class, 'role'])->name('role');
            Route::post('/create', [RoleController::class, 'roleCreate'])->name('role.create');
            Route::post('/delete', [RoleController::class, 'roleDelete'])->name('role.delete');
            Route::post('/edit', [RoleController::class, 'roleEdit'])->name('role.edit');
            Route::post('/update', [RoleController::class, 'roleUpdate'])->name('role.update');
        });
        // role route end

        // media route start
        Route::prefix('media')->group(function () {
            Route::prefix('album')->group(function () {
                Route::get('/album', [MediaController::class, 'mediaAlbum'])->name('media.album');
                Route::post('/create', [MediaController::class, 'albumCreate'])->name('album.create');
                Route::post('/delete', [MediaController::class, 'albumDelete'])->name('album.delete');
                Route::post('/status', [MediaController::class, 'albumStatus'])->name('album.status');
                Route::post('/edit', [MediaController::class, 'albumEdit'])->name('album.edit');
                Route::post('/update', [MediaController::class, 'albumUpdate'])->name('album.update');
            });
            Route::prefix('photo')->group(function () {
                Route::get('/', [MediaController::class, 'photoIndex'])->name('photo');
                Route::post('/create', [MediaController::class, 'photoCreate'])->name('photo.create');
                Route::post('/delete', [MediaController::class, 'photoDelete'])->name('photo.delete');
                Route::post('/status', [MediaController::class, 'photoStatus'])->name('photo.status');
                Route::post('/edit', [MediaController::class, 'photoEdit'])->name('photo.edit');
                Route::post('/update', [MediaController::class, 'photoUpdate'])->name('photo.update');
            });
            Route::prefix('video')->group(function () {
                Route::get('/', [MediaController::class, 'videoIndex'])->name('video');
                Route::post('/create', [MediaController::class, 'videoCreate'])->name('video.create');
                Route::post('/delete', [MediaController::class, 'videoDelete'])->name('video.delete');
                Route::post('/status', [MediaController::class, 'videoStatus'])->name('video.status');
                Route::post('/edit', [MediaController::class, 'videoEdit'])->name('video.edit');
                Route::post('/update', [MediaController::class, 'videoUpdate'])->name('video.update');
            });
        });
        // media route end

        // member route star
        Route::prefix('member')->group(function () {
            Route::get('/', [AdminMemberController::class, 'memberlist'])->name('member.list');
            Route::get('/request', [AdminMemberController::class, 'memberRequest'])->name('member.request');
            Route::get('/members/{id}/view', [AdminMemberController::class, 'view'])->name('member.view');
            Route::post('/members/approved', [AdminMemberController::class, 'approved'])->name('member.approved');
            Route::post('/members/suspend', [AdminMemberController::class, 'suspend'])->name('member.suspend');
            Route::post('/members/reject', [AdminMemberController::class, 'reject'])->name('member.reject');

            // Route::post('/view', [AdminMemberController::class, 'memberView'])->name('member.view');
        });
        // member route end

        // contact list route start
        // Route::prefix('member')->group(function () {
            Route::get('/contact/list', [SystemController::class, 'contactList'])->name('contact.list');
            Route::post('/contact/list/delete', [SystemController::class, 'contactListDelete'])->name('contact.list.delete');
        // });
        // contact list route end
    });
});

// frontend route start

Route::get('/', [IndexController::class, 'index'])->name('frontend.index');

Route::get('/{slug}', [FrontendPageController::class, 'show'])->name('frontend.static.page');

Route::get('/member/login', [FrontAuthController::class, 'login'])->name('frontend.login');
Route::post('/login/post', [FrontAuthController::class, 'loginPost'])->name('frontend.login.post');


Route::prefix('member')->group(function () {
    Route::get('/become-member', [MemberController::class, 'becomeMember'])->name('member');
    Route::post('/register', [MemberController::class, 'memberRegister'])->name('member.register');

    Route::middleware(['auth.member'])->group(function () {
        Route::get('/profile-own', [MemberController::class, 'memberOwnProfile'])->name('member.own.profile');
        Route::get('/profile-edit', [MemberController::class, 'memberProfile'])->name('member.profile');
        Route::post('/profile', [MemberController::class, 'profileUpdate'])->name('member.profile.update');
        Route::post('/profile/summary', [MemberController::class, 'profileUpdateSummary'])->name('member.profile.update.summary');
        Route::post('/profile/social', [MemberController::class, 'profileUpdateSocial'])->name('member.profile.update.social');
        Route::post('/profile/image', [MemberController::class, 'uploadProfileImage'])->name('upload.profile.image');
        Route::get('/logout', [MemberController::class, 'logout'])->name('member.logout');
    });

    Route::get('/ours/member', [FrontAuthController::class, 'oursMember'])->name('frontend.ours.member');
    Route::get('/{membership_id}', [FrontAuthController::class, 'profileShow'])->name('frontend.member.show');
    Route::get('profile/download/{membership_id}', [FrontAuthController::class, 'profileDownload'])->name('profile.download');
});

// post routes start
Route::get('/post/{categorySlug}', [FrontendPostController::class, 'index'])->name('frontend.blog.news');
Route::get('/post/{categorySlug}/{postSlug}', [FrontendPostController::class, 'showSinglePost'])->name('single.post');

Route::post('/comments', [FrontendPostController::class, 'storeComment'])->name('comments.store');
Route::post('/replies', [FrontendPostController::class, 'storeReply'])->name('replies.store');
Route::post('/reactions', [FrontendPostController::class, 'storeReaction'])->name('reactions.react');
Route::post('/delete', [FrontendPostController::class, 'deleteCommentOrReply'])->name('commentOrReply.delete');
// post routes end

//photo gallery start
Route::prefix('gallery')->group(function () {
    Route::get('/photo', [FrontendGalleryController::class, 'photoGallery'])->name('frontend.photo.gallery');
    Route::get('/photo/{id}', [FrontendGalleryController::class, 'singlePhotoGallery'])->name('singleAlbum');
    Route::get('/video', [FrontendGalleryController::class, 'videoGallery'])->name('frontend.video.gallery');
});

//photo gallery end
Route::prefix('contact')->group(function () {
    Route::get('/us', [IndexController::class, 'contact'])->name('frontend.contact');
    Route::post('/us/info', [IndexController::class, 'contactInfo'])->name('frontend.contact.info');
});

Route::get('/question/answer', [IndexController::class, 'faqs'])->name('frontend.faqs');
Route::get('/publication/list', [FrontnedPublicationController::class, 'index'])->name('frontend.publication');
// frontend route end