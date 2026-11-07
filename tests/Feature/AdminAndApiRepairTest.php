<?php

use App\Http\Controllers\Admin\AdmissionBannerController;
use App\Http\Controllers\Admin\AdmissionCriterionController;
use App\Http\Controllers\Admin\AdmissionFaqController;
use App\Http\Controllers\Admin\AdmissionPopupController;
use App\Http\Controllers\Admin\AdmissionStepController;
use App\Http\Controllers\Admin\AmenityCtaController;
use App\Http\Controllers\Admin\AboutSectionController;
use App\Http\Controllers\Admin\BreadcrumbBannerController;
use App\Http\Controllers\Admin\ChairmanMessageController;
use App\Http\Controllers\Admin\CampusLifeController;
use App\Http\Controllers\Admin\CareerBenefitController;
use App\Http\Controllers\Admin\CareerOpportunityController;
use App\Http\Controllers\Admin\EducationalSocietyController;
use App\Http\Controllers\Admin\GalleryAlbumController;
use App\Http\Controllers\Admin\GalleryItemController;
use App\Http\Controllers\Admin\HomeBannerController;
use App\Http\Controllers\Admin\MandatoryDisclosureController;
use App\Http\Controllers\Admin\NewsMediaController;
use App\Http\Controllers\Admin\PrincipalMessageController;
use App\Http\Controllers\Admin\PtaMemberController;
use App\Http\Controllers\Admin\SchoolManagementCommitteeController;
use App\Http\Controllers\Admin\VisionMissionController;
use App\Http\Controllers\Admin\WhyChooseController;
use App\Http\Controllers\Api\AdmissionEnquiryApiController;
use App\Http\Controllers\Api\AdmissionBannerApiController;
use App\Http\Controllers\Api\AdmissionPopupApiController;
use App\Http\Controllers\Api\BreadcrumbBannerApiController;
use App\Http\Controllers\Api\CampusLifeApiController;
use App\Http\Controllers\Api\ChairmanMessageApiController;
use App\Http\Controllers\Api\PrincipalMessageApiController;
use App\Http\Controllers\Api\AboutApiController;
use App\Http\Controllers\Api\ContactApiController;
use App\Http\Controllers\Api\HomeBannerApiController;
use App\Models\BreadcrumbBanner;
use App\Models\AdmissionPopup;
use App\Models\CampusLife;
use App\Models\WhyChooseFeature;
use Database\Seeders\CampusLifeSeeder;
use Database\Seeders\WhyChooseFeatureSeeder;
use App\Http\Requests\AdmissionBannerRequest;
use App\Http\Requests\AdmissionEnquiryRequest;
use App\Http\Requests\AdmissionPopupRequest;
use App\Http\Requests\AboutSectionRequest;
use App\Http\Requests\ContactInquiryRequest;
use App\Http\Requests\CampusLifeRequest;
use App\Http\Requests\ChairmanMessageRequest;
use App\Http\Requests\HomeBannerRequest;
use App\Http\Requests\PrincipalMessageRequest;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ViewErrorBag;
use Illuminate\View\View;
use PHPUnit\Framework\TestCase;

final class AdminAndApiRepairTest extends TestCase
{
    private $app;

    protected function setUp(): void
    {
        parent::setUp();
        Facade::clearResolvedInstances();

        $this->app = require dirname(__DIR__, 2).'/bootstrap/app.php';
        $this->app->make(Kernel::class)->bootstrap();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
            'database.connections.sqlite.prefix' => '',
            'database.connections.sqlite.foreign_key_constraints' => true,
            'session.driver' => 'array',
        ]);
        DB::purge('sqlite');
        DB::setDefaultConnection('sqlite');
        $this->createTables();
    }

    protected function tearDown(): void
    {
        DB::purge('sqlite');
        restore_error_handler();
        restore_exception_handler();

        parent::tearDown();
    }

    public function test_banner_and_popup_get_handlers_are_read_only(): void
    {
        DB::table('home_banners')->insert([
            'image_path' => 'uploads/home_banners/home_banner_iit_jee_neet.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('breadcrumb_banners')->insert([
            'page_name' => 'Legacy page',
            'page_slug' => 'unsupported-legacy-page',
            'breadcrumb_title' => 'Legacy',
            'title' => 'Legacy title',
            'highlighted_title' => 'Legacy highlight',
            'background_image' => null,
            'subtitle' => 'Keep this column',
            'sort_order' => 99,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $breadcrumbColumns = Schema::getColumnListing('breadcrumb_banners');
        $popupColumns = Schema::getColumnListing('admission_popups');

        (new HomeBannerController)->index();
        (new HomeBannerApiController)->getBanner();
        (new BreadcrumbBannerController)->index(Request::create('/admin/breadcrumb-banners'));
        $popupView = (new AdmissionPopupController)->index();

        self::assertSame(1, DB::table('home_banners')->count());
        self::assertSame(1, DB::table('breadcrumb_banners')->count());
        self::assertSame('unsupported-legacy-page', DB::table('breadcrumb_banners')->value('page_slug'));
        self::assertSame(0, DB::table('admission_popups')->count());
        self::assertSame(0, $popupView->getData()['popups']->total());
        self::assertSame($breadcrumbColumns, Schema::getColumnListing('breadcrumb_banners'));
        self::assertSame($popupColumns, Schema::getColumnListing('admission_popups'));
    }

    public function test_breadcrumb_create_dropdown_hides_used_pages_and_restores_deleted_pages(): void
    {
        $controller = new BreadcrumbBannerController;
        $supportedSlugs = array_column(BreadcrumbBanner::supportedPages(), 'slug');
        $initialSlugs = array_column($controller->create()->getData()['supportedPages'], 'slug');

        self::assertSame($supportedSlugs, $initialSlugs);

        $bannerId = DB::table('breadcrumb_banners')->insertGetId([
            'page_name' => 'About JRS',
            'page_slug' => 'about',
            'breadcrumb_title' => 'About JRS',
            'title' => 'About',
            'highlighted_title' => 'JRS',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $slugsAfterCreate = array_column($controller->create()->getData()['supportedPages'], 'slug');
        self::assertNotContains('about', $slugsAfterCreate);

        $controller->destroy($bannerId);

        $slugsAfterDelete = array_column($controller->create()->getData()['supportedPages'], 'slug');
        self::assertContains('about', $slugsAfterDelete);
    }

    public function test_breadcrumb_banner_does_not_use_default_image_and_requires_upload_on_create(): void
    {
        $banner = new BreadcrumbBanner(['background_image' => null]);
        self::assertNull($banner->background_image_url);

        $response = (new BreadcrumbBannerApiController)->getBySlug('about');
        self::assertNull($response->getData(true)['data']['background_image']);

        $request = new \App\Http\Requests\BreadcrumbBannerRequest;
        $request->initialize([
            'page_name' => 'About JRS',
            'page_slug' => 'about',
            'breadcrumb_title' => 'About JRS',
            'title' => 'About',
            'highlighted_title' => 'JRS',
        ]);
        $request->setMethod('POST');
        $request->headers->set('Accept', 'application/json');
        $request->setContainer($this->app);
        $request->setRedirector($this->app->make(Redirector::class));

        try {
            $request->validateResolved();
            self::fail('Creating a breadcrumb banner without an uploaded image should fail validation.');
        } catch (HttpResponseException $exception) {
            self::assertSame(422, $exception->getResponse()->getStatusCode());
            self::assertArrayHasKey(
                'background_image',
                $exception->getResponse()->getData(true)['errors']
            );
        }
    }

    public function test_about_button_fields_are_ignored_and_hidden_without_losing_existing_data(): void
    {
        $aboutId = DB::table('about_sections')->insertGetId([
            'tagline' => 'ABOUT JRS',
            'title' => 'Original title',
            'description_p1' => 'Original description.',
            'button_text' => 'Legacy button',
            'button_link' => '/legacy-about',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $request = $this->validatedRequest(AboutSectionRequest::class, [
            'tagline' => 'ABOUT JRS',
            'title' => 'Updated title',
            'description_p1' => 'Updated description.',
            'button_text' => 'Submitted button',
            'button_link' => '/submitted-about',
            'is_active' => '1',
        ]);

        self::assertArrayNotHasKey('button_text', $request->validated());
        self::assertArrayNotHasKey('button_link', $request->validated());

        (new AboutSectionController)->update($request, $aboutId);

        self::assertSame('Updated title', DB::table('about_sections')->where('id', $aboutId)->value('title'));
        self::assertSame('Legacy button', DB::table('about_sections')->where('id', $aboutId)->value('button_text'));
        self::assertSame('/legacy-about', DB::table('about_sections')->where('id', $aboutId)->value('button_link'));

        $responseData = (new AboutApiController)->getAbout()->getData(true)['data'];
        self::assertArrayNotHasKey('button_text', $responseData);
        self::assertArrayNotHasKey('button_link', $responseData);
    }

    public function test_about_create_form_is_empty_and_api_only_returns_active_saved_content(): void
    {
        $controller = new AboutSectionController;
        view()->share('errors', new \Illuminate\Support\ViewErrorBag);
        $createForm = $controller->create()->render();

        self::assertStringContainsString('name="tagline" value=""', $createForm);
        self::assertStringContainsString('name="title" value=""', $createForm);
        self::assertStringContainsString('name="title_highlight" value=""', $createForm);
        self::assertStringContainsString('name="video_title" value=""', $createForm);
        self::assertStringContainsString('name="video_url" value=""', $createForm);
        self::assertStringNotContainsString('placeholder=', $createForm);
        self::assertSame(404, (new AboutApiController)->getAbout()->getStatusCode());

        DB::table('about_sections')->insert([
            'tagline' => 'Saved tagline',
            'title' => 'Saved title',
            'description_p1' => 'Saved description.',
            'is_active' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        self::assertSame(404, (new AboutApiController)->getAbout()->getStatusCode());

        DB::table('about_sections')->update(['is_active' => true]);
        $response = (new AboutApiController)->getAbout();
        self::assertSame(200, $response->getStatusCode());
        self::assertSame('Saved title', $response->getData(true)['data']['title']);
    }

    public function test_about_column_defaults_are_removed_without_changing_existing_records(): void
    {
        $aboutId = DB::table('about_sections')->insertGetId([
            'tagline' => 'Previously saved tagline',
            'title' => 'Previously saved title',
            'title_highlight' => 'Previously saved highlight',
            'description_p1' => 'Previously saved description.',
            'video_title' => 'Previously saved video title',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $migration = require dirname(__DIR__, 2).'/database/migrations/2026_11_05_000001_remove_defaults_from_about_sections_table.php';
        $migration->up();

        $record = DB::table('about_sections')->where('id', $aboutId)->first();
        self::assertSame('Previously saved tagline', $record->tagline);
        self::assertSame('Previously saved title', $record->title);
        self::assertSame('Previously saved highlight', $record->title_highlight);
        self::assertSame('Previously saved video title', $record->video_title);

        $columns = collect(DB::select('PRAGMA table_info(about_sections)'))->keyBy('name');
        foreach (['tagline', 'title', 'title_highlight', 'video_title'] as $name) {
            self::assertNull($columns[$name]->dflt_value);
        }
    }

    public function test_about_admin_allows_only_one_record_and_restores_create_after_delete(): void
    {
        $controller = new AboutSectionController;
        self::assertFalse($controller->index(Request::create('/admin/about'))->getData()['hasAboutSection']);
        self::assertInstanceOf(View::class, $controller->create());

        $aboutId = DB::table('about_sections')->insertGetId([
            'tagline' => 'ABOUT JRS',
            'title' => 'Existing About',
            'description_p1' => 'Existing description.',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        self::assertTrue($controller->index(Request::create('/admin/about'))->getData()['hasAboutSection']);
        self::assertInstanceOf(RedirectResponse::class, $controller->create());

        $duplicateResponse = $controller->store($this->validatedRequest(AboutSectionRequest::class, [
            'tagline' => 'ABOUT JRS',
            'title' => 'Duplicate About',
            'description_p1' => 'This duplicate must not be stored.',
        ]));
        self::assertSame(1, DB::table('about_sections')->count());
        self::assertSame(
            'Only one About JRS record is allowed. Edit or delete the existing record first.',
            $duplicateResponse->getSession()->get('errors')->first('about')
        );

        $controller->destroy($aboutId);
        self::assertFalse($controller->index(Request::create('/admin/about'))->getData()['hasAboutSection']);
        self::assertInstanceOf(View::class, $controller->create());
    }

    public function test_chairman_and_principal_admin_records_support_create_update_delete_and_api_output(): void
    {
        $chairmanController = new ChairmanMessageController;
        $chairmanCreate = $chairmanController->create();
        self::assertInstanceOf(View::class, $chairmanCreate);
        self::assertTrue($chairmanCreate->getData()['isCreate']);
        self::assertTrue(\Illuminate\Support\Facades\Route::has('admin.chairman.create'));
        self::assertTrue(\Illuminate\Support\Facades\Route::has('admin.chairman.store'));
        self::assertTrue(\Illuminate\Support\Facades\Route::has('admin.chairman.destroy'));

        $chairmanStoreResponse = $chairmanController->store($this->validatedRequest(ChairmanMessageRequest::class, [
            'title' => 'Chairman Test Heading',
            'name' => 'Test Chairman',
            'paragraph' => 'Chairman API test content.',
            'commitment_title' => 'Chairman Commitment',
        ]));
        self::assertSame(route('admin.chairman.index'), $chairmanStoreResponse->getTargetUrl());
        self::assertSame(
            'Chairman Leadership page sections created successfully!',
            $chairmanStoreResponse->getSession()->get('success')
        );
        $chairman = \App\Models\ChairmanMessage::firstOrFail();
        self::assertSame('Chairman Test Heading', $chairman->title);
        self::assertTrue($chairmanController->index()->getData()['chairmen']->contains('id', $chairman->id));
        self::assertSame('Chairman API test content.', (new ChairmanMessageApiController)->index()->getData(true)['data']['paragraph']);

        $chairmanController->update($this->validatedRequest(ChairmanMessageRequest::class, [
            'title' => 'Updated Chairman Heading',
            'name' => 'Test Chairman',
            'paragraph' => 'Updated chairman API content.',
            'commitment_title' => 'Updated Commitment',
            'is_active' => '1',
        ]), $chairman->id);
        self::assertSame('Updated Chairman Heading', $chairman->fresh()->title);
        self::assertSame('Updated chairman API content.', (new ChairmanMessageApiController)->index()->getData(true)['data']['paragraph']);
        $chairmanController->destroy($chairman->id);
        self::assertSame(0, DB::table('chairman_messages')->count());

        $principalController = new PrincipalMessageController;
        $principalCreate = $principalController->create();
        self::assertInstanceOf(View::class, $principalCreate);
        self::assertTrue($principalCreate->getData()['isCreate']);
        self::assertTrue(\Illuminate\Support\Facades\Route::has('admin.principal.create'));
        self::assertTrue(\Illuminate\Support\Facades\Route::has('admin.principal.store'));
        self::assertTrue(\Illuminate\Support\Facades\Route::has('admin.principal.destroy'));

        $principalStoreResponse = $principalController->store($this->validatedRequest(PrincipalMessageRequest::class, [
            'title' => 'Principal Test Heading',
            'name' => 'Test Principal',
            'paragraph' => 'Principal API test content.',
            'is_active' => '1',
        ]));
        self::assertSame(route('admin.principal.index'), $principalStoreResponse->getTargetUrl());
        self::assertSame(
            'Principal leadership message created successfully!',
            $principalStoreResponse->getSession()->get('success')
        );
        $principal = \App\Models\PrincipalMessage::firstOrFail();
        self::assertSame('Principal Test Heading', $principal->title);
        self::assertTrue($principalController->index()->getData()['principals']->contains('id', $principal->id));
        self::assertSame('Principal API test content.', (new PrincipalMessageApiController)->index()->getData(true)['data']['paragraph']);

        $principalController->update($this->validatedRequest(PrincipalMessageRequest::class, [
            'title' => 'Updated Principal Heading',
            'name' => 'Test Principal',
            'paragraph' => 'Updated principal API content.',
            'is_active' => '1',
        ]), $principal->id);
        self::assertSame('Updated Principal Heading', $principal->fresh()->title);
        self::assertSame('Updated principal API content.', (new PrincipalMessageApiController)->index()->getData(true)['data']['paragraph']);
        $principalController->destroy($principal->id);
        self::assertSame(0, DB::table('principal_messages')->count());
    }

    public function test_admission_popup_admin_limits_to_one_card_and_allows_delete(): void
    {
        $controller = new AdmissionPopupController;
        self::assertSame(0, $controller->index()->getData()['popups']->total());
        self::assertFalse($controller->create()->getData()['popup']->exists);
        self::assertTrue(\Illuminate\Support\Facades\Route::has('admin.admission-popup.destroy'));

        $first = $this->admissionPopupData([
            'badge_text' => 'First popup',
            'is_active' => '1',
        ]);
        $controller->store($this->validatedRequest(AdmissionPopupRequest::class, $first));

        $firstPopup = AdmissionPopup::firstOrFail();
        self::assertSame('First popup', $firstPopup->badge_text);
        self::assertSame(1, $controller->index()->getData()['popups']->total());
        self::assertSame($firstPopup->id, $controller->edit($firstPopup->id)->getData()['popup']->id);

        $second = $this->admissionPopupData([
            'badge_text' => 'Second popup',
            'is_active' => '1',
        ]);
        $duplicateResponse = $controller->store($this->validatedRequest(AdmissionPopupRequest::class, $second));
        self::assertSame(1, AdmissionPopup::count());
        self::assertSame(
            'Only one Admission Popup card is allowed. Edit or delete the existing card first.',
            $duplicateResponse->getSession()->get('errors')->first('popup')
        );
        self::assertInstanceOf(RedirectResponse::class, $controller->create());
        self::assertSame('First popup', (new AdmissionPopupApiController)->getPopup()->getData(true)['data']['badge_text']);

        $controller->update(
            $this->validatedRequest(AdmissionPopupRequest::class, $this->admissionPopupData([
                'id' => $firstPopup->id,
                'badge_text' => 'Updated first popup',
                'is_active' => '1',
            ])),
            $firstPopup->id
        );

        self::assertSame('Updated first popup', $firstPopup->fresh()->badge_text);
        self::assertTrue($firstPopup->fresh()->is_active);

        $controller->toggle($firstPopup->id);
        self::assertFalse($firstPopup->fresh()->is_active);
        self::assertSame(404, (new AdmissionPopupApiController)->getPopup()->getStatusCode());

        $controller->destroy($firstPopup->id);
        self::assertSame(0, AdmissionPopup::count());
        self::assertFalse($controller->create()->getData()['popup']->exists);
    }

    public function test_all_previously_missing_resource_actions_are_present(): void
    {
        $actions = [
            AdmissionBannerController::class => ['create', 'store', 'show', 'destroy'],
            HomeBannerController::class => ['create', 'edit', 'show', 'update'],
            AdmissionCriterionController::class => ['show'],
            AdmissionFaqController::class => ['show'],
            AdmissionStepController::class => ['show'],
            AmenityCtaController::class => ['show'],
            CampusLifeController::class => ['show'],
            CareerBenefitController::class => ['show'],
            CareerOpportunityController::class => ['show'],
            EducationalSocietyController::class => ['show'],
            GalleryAlbumController::class => ['show'],
            GalleryItemController::class => ['show'],
            MandatoryDisclosureController::class => ['show'],
            NewsMediaController::class => ['show'],
            PtaMemberController::class => ['show'],
            SchoolManagementCommitteeController::class => ['show'],
            VisionMissionController::class => ['show'],
            WhyChooseController::class => ['show'],
        ];

        foreach ($actions as $controller => $methods) {
            foreach ($methods as $method) {
                self::assertTrue(method_exists($controller, $method), $controller.'::'.$method.' is missing');
            }
        }
    }

    public function test_missing_resource_show_actions_redirect_to_edit_forms(): void
    {
        $showRoutes = [
            AdmissionBannerController::class => 'admin.admission-banner.edit',
            HomeBannerController::class => 'admin.home-banners.edit',
            AdmissionCriterionController::class => 'admin.admission-criteria.edit',
            AdmissionFaqController::class => 'admin.admission-faqs.edit',
            AdmissionStepController::class => 'admin.admission-steps.edit',
            AmenityCtaController::class => 'admin.amenities-cta.edit',
            CampusLifeController::class => 'admin.campus-life.edit',
            CareerBenefitController::class => 'admin.careers-benefits.edit',
            CareerOpportunityController::class => 'admin.careers-opportunities.edit',
            EducationalSocietyController::class => 'admin.educational-society.edit',
            GalleryAlbumController::class => 'admin.gallery-albums.edit',
            GalleryItemController::class => 'admin.gallery-items.edit',
            MandatoryDisclosureController::class => 'admin.mandatory-disclosure.edit',
            NewsMediaController::class => 'admin.news-media.edit',
            PtaMemberController::class => 'admin.pta-members.edit',
            SchoolManagementCommitteeController::class => 'admin.school-management-committee.edit',
            VisionMissionController::class => 'admin.vision-mission.edit',
            WhyChooseController::class => 'admin.why-choose.edit',
        ];

        foreach ($showRoutes as $controller => $routeName) {
            $response = (new $controller)->show(17);
            self::assertInstanceOf(RedirectResponse::class, $response);
            self::assertSame(route($routeName, 17), $response->getTargetUrl());
        }
    }

    public function test_why_choose_create_and_edit_views_render_their_content_sections(): void
    {
        $viewData = ['errors' => new ViewErrorBag];
        $createHtml = view('admin.why-choose.create', $viewData + ['nextOrder' => 1])->render();
        self::assertStringContainsString('New Feature Card', $createHtml);
        self::assertStringContainsString('Save Feature Item', $createHtml);
        self::assertSame(1, substr_count($createHtml, 'id="sort_order"'));

        $item = new WhyChooseFeature([
            'title' => 'Test feature',
            'description' => 'Test description',
            'icon' => 'bi bi-trophy-fill',
            'is_active' => true,
            'sort_order' => 1,
        ]);
        $item->id = 1;

        $editHtml = view('admin.why-choose.edit', $viewData + compact('item'))->render();
        self::assertStringContainsString('Edit: Test feature', $editHtml);
        self::assertStringContainsString('Update Feature Item', $editHtml);
        self::assertSame(1, substr_count($editHtml, 'id="sort_order"'));
    }

    public function test_why_choose_seeder_preserves_existing_records_and_is_safe_to_rerun(): void
    {
        $existing = WhyChooseFeature::create([
            'type' => 'card',
            'title' => 'Academic Excellence',
            'description' => 'Admin-edited description.',
            'icon' => 'bi bi-star',
            'icon_color' => 'purple',
            'sort_order' => 8,
            'is_active' => false,
        ]);
        WhyChooseFeature::create([
            'type' => 'card',
            'title' => 'Custom Admin Feature',
            'description' => 'Do not delete admin content.',
            'sort_order' => 50,
            'is_active' => true,
        ]);

        $seeder = new WhyChooseFeatureSeeder;
        $seeder->run();
        $seeder->run();

        self::assertSame(14, WhyChooseFeature::count());
        self::assertSame('Admin-edited description.', $existing->fresh()->description);
        self::assertFalse($existing->fresh()->is_active);
        self::assertSame(1, WhyChooseFeature::where('title', 'Academic Excellence')->count());
        self::assertSame(1, WhyChooseFeature::where('title', 'Custom Admin Feature')->count());
    }

    public function test_campus_life_seeder_preserves_existing_cards_and_is_safe_to_rerun(): void
    {
        $existing = CampusLife::create([
            'title' => 'Eco-Friendly Campus',
            'icon' => 'bi bi-star',
            'sort_order' => 8,
            'is_active' => false,
        ]);
        CampusLife::create([
            'title' => 'Custom Admin Campus Card',
            'sort_order' => 50,
            'is_active' => true,
        ]);

        $seeder = new CampusLifeSeeder;
        $seeder->run();
        $seeder->run();

        self::assertSame(5, CampusLife::count());
        self::assertFalse($existing->fresh()->is_active);
        self::assertSame(1, CampusLife::where('title', 'Eco-Friendly Campus')->count());
        self::assertSame(1, CampusLife::where('title', 'Custom Admin Campus Card')->count());
    }

    public function test_campus_life_crud_and_api_work_without_subtitle_column(): void
    {
        $existingId = DB::table('campus_lives')->insertGetId([
            'title' => 'Existing Campus Card',
            'subtitle' => 'Legacy tagline',
            'icon' => 'bi bi-tree-fill',
            'image_path' => 'uploads/campus-life/existing.jpg',
            'sort_order' => 3,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $migration = require dirname(__DIR__, 2).'/database/migrations/2026_11_05_000002_drop_subtitle_from_campus_lives_table.php';
        $migration->up();

        self::assertFalse(Schema::hasColumn('campus_lives', 'subtitle'));
        self::assertSame('Existing Campus Card', DB::table('campus_lives')->where('id', $existingId)->value('title'));
        self::assertSame('uploads/campus-life/existing.jpg', DB::table('campus_lives')->where('id', $existingId)->value('image_path'));

        $this->app['session']->driver()->start();

        $controller = new CampusLifeController;
        $storeRequest = $this->validatedRequest(CampusLifeRequest::class, [
            'title' => 'New Campus Card',
            'subtitle' => 'Legacy tagline should be ignored',
            'icon' => 'bi bi-book-half',
            'image_path' => 'uploads/campus-life/new.jpg',
            'sort_order' => 4,
        ]);
        self::assertArrayNotHasKey('subtitle', $storeRequest->validated());
        $controller->store($storeRequest);

        $created = CampusLife::where('title', 'New Campus Card')->firstOrFail();
        self::assertSame(4, $created->sort_order);
        self::assertSame('bi bi-book-half', $created->icon);

        $response = (new CampusLifeApiController)->index();
        self::assertSame(200, $response->getStatusCode());
        self::assertArrayNotHasKey('subtitle', $response->getData(true)['data'][0]);

        $updateRequest = $this->validatedRequest(CampusLifeRequest::class, [
            'title' => 'Updated Campus Card',
            'subtitle' => 'This field is not persisted',
            'icon' => 'bi bi-stars',
            'sort_order' => 5,
        ]);
        $controller->update($updateRequest, $created->id);
        self::assertSame('Updated Campus Card', $created->fresh()->title);
        self::assertSame('bi bi-stars', $created->fresh()->icon);
        self::assertArrayNotHasKey(
            'subtitle',
            (new CampusLifeApiController)->index()->getData(true)['data'][1]
        );
        self::assertInstanceOf(
            RoutingRoute::class,
            \Illuminate\Support\Facades\Route::getRoutes()->match(Request::create('/api/campus-tour', 'GET'))
        );
        self::assertInstanceOf(
            RoutingRoute::class,
            \Illuminate\Support\Facades\Route::getRoutes()->match(Request::create('/api/campus-life', 'GET'))
        );

        $controller->destroy($created->id);
        self::assertSame(1, CampusLife::count());
    }

    public function test_admission_and_home_banner_crud_works_in_isolated_sqlite(): void
    {
        $this->app['session']->driver()->start();

        $admissionController = new AdmissionBannerController;
        $admissionCreateView = $admissionController->create();
        self::assertInstanceOf(View::class, $admissionCreateView);
        self::assertFalse($admissionCreateView->getData()['banner']->exists);
        $admissionRequest = $this->validatedRequest(AdmissionBannerRequest::class, [
            'title' => 'Test admission banner',
            'image_path' => 'uploads/admission-banner/test-only-isolated-banner.jpg',
        ]);
        $admissionController->store($admissionRequest);
        $admission = DB::table('admission_banners')->first();
        self::assertNotNull($admission);
        self::assertSame('Test admission banner', $admission->title);
        self::assertInstanceOf(View::class, $admissionController->edit($admission->id));

        $admissionController->update(
            $this->validatedRequest(AdmissionBannerRequest::class, ['title' => 'Updated test banner']),
            $admission->id
        );
        self::assertSame('Updated test banner', DB::table('admission_banners')->where('id', $admission->id)->value('title'));
        $admissionController->destroy($admission->id);
        self::assertSame(0, DB::table('admission_banners')->count());

        $homeController = new HomeBannerController;
        $homeCreateView = $homeController->create();
        self::assertInstanceOf(View::class, $homeCreateView);
        self::assertSame(route('admin.home-banners.store'), $homeCreateView->getData()['formAction']);
        $homeController->store($this->validatedRequest(HomeBannerRequest::class, [
            'image_path' => 'uploads/home_banners/test-only-isolated-banner.jpg',
        ]));
        $home = DB::table('home_banners')->first();
        self::assertNotNull($home);
        self::assertSame('uploads/home_banners/test-only-isolated-banner.jpg', $home->image_path);
        $homeEditView = $homeController->edit($home->id);
        self::assertSame(route('admin.home-banners.update', $home->id), $homeEditView->getData()['formAction']);
        self::assertSame('PUT', $homeEditView->getData()['formMethod']);

        $homeController->update(
            $this->validatedRequest(HomeBannerRequest::class, [
                'image_path' => 'uploads/home_banners/updated-test-only-isolated-banner.jpg',
            ]),
            $home->id
        );
        self::assertSame(
            'uploads/home_banners/updated-test-only-isolated-banner.jpg',
            DB::table('home_banners')->where('id', $home->id)->value('image_path')
        );
        $homeController->destroy($home->id);
        self::assertSame(0, DB::table('home_banners')->count());
    }

    public function test_admission_banner_button_columns_are_removed_and_crud_api_and_views_exclude_them(): void
    {
        $bannerId = DB::table('admission_banners')->insertGetId([
            'title' => 'Existing Admission Banner',
            'title_highlight' => 'Existing highlight',
            'description' => 'Existing description.',
            'primary_button_text' => 'Legacy primary label',
            'primary_button_link' => '/legacy-primary',
            'secondary_button_text' => 'Legacy secondary label',
            'secondary_button_link' => '/legacy-secondary',
            'image_path' => 'images/existing-banner.jpg',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $migration = require dirname(__DIR__, 2).'/database/migrations/2026_11_05_000003_drop_button_fields_from_admission_banners_table.php';
        $migration->up();

        foreach (['primary_button_text', 'primary_button_link', 'secondary_button_text', 'secondary_button_link'] as $column) {
            self::assertFalse(Schema::hasColumn('admission_banners', $column));
        }
        $existing = DB::table('admission_banners')->find($bannerId);
        self::assertSame('Existing Admission Banner', $existing->title);
        self::assertSame('images/existing-banner.jpg', $existing->image_path);
        DB::table('admission_banners')->where('id', $bannerId)->update(['is_active' => false]);

        $migration->down();
        foreach (['primary_button_text', 'primary_button_link', 'secondary_button_text', 'secondary_button_link'] as $column) {
            self::assertTrue(Schema::hasColumn('admission_banners', $column));
        }
        self::assertSame('Enquire for Admission', DB::table('admission_banners')->where('id', $bannerId)->value('primary_button_text'));
        self::assertNull(DB::table('admission_banners')->where('id', $bannerId)->value('primary_button_link'));
        self::assertSame('Take a Campus Tour', DB::table('admission_banners')->where('id', $bannerId)->value('secondary_button_text'));
        self::assertSame('/campus-tour', DB::table('admission_banners')->where('id', $bannerId)->value('secondary_button_link'));
        $restoredColumns = collect(DB::select('PRAGMA table_info(admission_banners)'))->keyBy('name');
        self::assertSame("'Enquire for Admission'", $restoredColumns['primary_button_text']->dflt_value);
        self::assertSame("'Take a Campus Tour'", $restoredColumns['secondary_button_text']->dflt_value);
        self::assertSame("'/campus-tour'", $restoredColumns['secondary_button_link']->dflt_value);
        self::assertSame('Existing Admission Banner', DB::table('admission_banners')->where('id', $bannerId)->value('title'));
        $migration->up();
        (new \Database\Seeders\AdmissionBannerSeeder)->run();
        self::assertSame(
            'Give Your Child A Strong Foundation',
            DB::table('admission_banners')->where('id', $bannerId)->value('title')
        );
        DB::table('admission_banners')->where('id', $bannerId)->update(['is_active' => false]);

        $this->app['session']->driver()->start();
        $controller = new AdmissionBannerController;
        $createView = $controller->create();
        $createView->with('errors', new ViewErrorBag);
        $createHtml = $createView->render();
        foreach (['primary_button_text', 'primary_button_link', 'secondary_button_text', 'secondary_button_link'] as $field) {
            self::assertStringNotContainsString($field, $createHtml);
        }
        $editView = $controller->edit($bannerId);
        $editView->with('errors', new ViewErrorBag);
        $editHtml = $editView->render();
        foreach (['primary_button_text', 'primary_button_link', 'secondary_button_text', 'secondary_button_link'] as $field) {
            self::assertStringNotContainsString($field, $editHtml);
        }

        $request = $this->validatedRequest(AdmissionBannerRequest::class, [
            'title' => 'New CTA-Free Banner',
            'description' => 'Banner content without buttons.',
            'primary_button_text' => 'Ignore this input',
            'primary_button_link' => '/ignore-primary',
            'secondary_button_text' => 'Ignore this input too',
            'secondary_button_link' => '/ignore-secondary',
        ]);
        foreach (['primary_button_text', 'primary_button_link', 'secondary_button_text', 'secondary_button_link'] as $field) {
            self::assertArrayNotHasKey($field, $request->validated());
        }
        $controller->store($request);

        $created = \App\Models\AdmissionBanner::where('title', 'New CTA-Free Banner')->firstOrFail();
        self::assertSame('Banner content without buttons.', $created->description);
        $indexView = $controller->index();
        self::assertInstanceOf(View::class, $indexView);
        $indexHtml = $indexView->render();
        self::assertStringNotContainsString('Primary Button', $indexHtml);
        self::assertStringNotContainsString('Secondary Button', $indexHtml);

        $apiResponse = (new AdmissionBannerApiController)->index();
        self::assertSame(200, $apiResponse->getStatusCode());
        $apiData = $apiResponse->getData(true)['data'];
        foreach (['primary_button_text', 'primary_button_link', 'secondary_button_text', 'secondary_button_link', 'primary_button', 'secondary_button'] as $field) {
            self::assertArrayNotHasKey($field, $apiData);
        }

        foreach (['public/swagger.json', 'storage/api-docs/api-docs.json'] as $documentationPath) {
            $openApi = json_decode(
                file_get_contents(base_path($documentationPath)),
                true,
                512,
                JSON_THROW_ON_ERROR
            );
            $bannerOperation = $openApi['paths']['/admission-banner']['get'];
            $bannerSchema = $bannerOperation['responses']['200']['content']['application/json']['schema'];
            $documentedFields = array_keys($bannerSchema['properties']['data']['properties']);

            foreach (['primary_button_text', 'primary_button_link', 'secondary_button_text', 'secondary_button_link', 'primary_button', 'secondary_button'] as $field) {
                self::assertNotContains($field, $documentedFields);
            }
            self::assertStringNotContainsString('CTA', $bannerOperation['summary']);
            self::assertStringNotContainsString('CTA', $bannerOperation['tags'][0]);
        }

        $controller->update(
            $this->validatedRequest(AdmissionBannerRequest::class, ['title' => 'Updated CTA-Free Banner']),
            $created->id
        );
        self::assertSame('Updated CTA-Free Banner', $created->fresh()->title);
        $controller->destroy($created->id);
        self::assertSame(1, DB::table('admission_banners')->count());
    }

    public function test_contact_and_admission_forms_store_in_isolated_sqlite(): void
    {
        $admission = $this->validatedRequest(AdmissionEnquiryRequest::class, [
            'grade' => 'Grade 1',
            'parent_mobile' => '9157404321',
            'student_dob' => '2020-05-15',
            'notes' => 'Test-only enquiry',
        ], 'application/json');
        $admissionResponse = (new AdmissionEnquiryApiController)->store($admission);
        self::assertSame(201, $admissionResponse->getStatusCode());
        self::assertSame(
            'Thank you! Your admission enquiry has been submitted successfully. Our admissions counsellor will contact you shortly.',
            $admissionResponse->getData(true)['message']
        );
        self::assertArrayNotHasKey('application_number', $admissionResponse->getData(true)['data']);
        self::assertSame(1, DB::table('admission_enquiries')->count());
        self::assertSame('Test-only enquiry', DB::table('admission_enquiries')->value('notes'));

        $contact = $this->validatedRequest(ContactInquiryRequest::class, [
            'parent_name' => 'Test Parent',
            'phone' => '9157404322',
            'grade' => 'Grade 2',
            'email' => 'test@example.com',
            'message' => 'Isolated test inquiry',
            'notes' => 'Test-only notes',
        ], 'application/json');
        $contactResponse = (new ContactApiController)->storeInquiry($contact);
        self::assertSame(201, $contactResponse->getStatusCode());
        self::assertSame(
            'Thank you! Your message has been sent successfully. Our admissions counselor will get back to you within 24 hours.',
            $contactResponse->getData(true)['message']
        );
        self::assertSame(1, DB::table('contact_inquiries')->count());
        self::assertSame('Test-only notes', DB::table('contact_inquiries')->value('notes'));
    }

    public function test_invalid_contact_submission_returns_json_422_in_isolated_sqlite(): void
    {
        $request = new ContactInquiryRequest;
        $request->initialize([]);
        $request->headers->set('Accept', 'application/json');
        $request->setContainer($this->app);
        $request->setRedirector($this->app->make(Redirector::class));

        try {
            $request->validateResolved();
            self::fail('Invalid contact inquiry should fail validation.');
        } catch (HttpResponseException $exception) {
            self::assertSame(422, $exception->getResponse()->getStatusCode());
            self::assertFalse($exception->getResponse()->getData(true)['success']);
        }

        self::assertSame(0, DB::table('contact_inquiries')->count());
    }

    private function validatedRequest(string $class, array $data, string $accept = 'text/html')
    {
        $request = new $class;
        $request->initialize($data);
        $request->headers->set('Accept', $accept);
        $request->setContainer($this->app);
        $request->setRedirector($this->app->make(Redirector::class));
        $request->validateResolved();

        return $request;
    }

    private function admissionPopupData(array $overrides = []): array
    {
        return array_merge([
            'is_active' => '0',
            'image_path' => 'https://example.test/admission-popup.jpg',
            'badge_text' => 'ADMISSIONS OPEN',
            'cbse_affiliation_text' => 'CBSE affiliation',
            'school_name' => 'JRS International School',
            'school_location' => 'Hyderabad',
            'academic_year_badge' => 'Academic Year 2027 - 2028',
            'title_prefix' => 'Admissions Open For',
            'academic_year_highlight' => '2027 - 2028',
            'description' => 'Admission information.',
            'features' => ['CBSE curriculum'],
            'phone_number' => '+91 90000 00000',
        ], $overrides);
    }

    private function createTables(): void
    {
        Schema::create('chairman_messages', function (Blueprint $table): void {
            $table->id();
            $table->string('section_badge')->default("CHAIRMAN'S ADDRESS");
            $table->string('title')->default('Empowering Young Minds For A Changing World');
            $table->string('profile_badge')->default('FOUNDING LEADERSHIP');
            $table->string('name')->default('Chairman Of JRS');
            $table->string('sub_title')->default('JRS International School • Hyderabad');
            $table->text('quote')->nullable();
            $table->string('image_path')->nullable();
            $table->text('paragraph')->nullable();
            $table->string('signoff_note')->default('WITH WARM WISHES & COMMITMENT,');
            $table->string('signoff_name')->default('Chairman');
            $table->string('signoff_sub')->default('JRS International School, Hyderabad');
            $table->string('commitment_badge')->default('OUR STRATEGIC COMMITMENT');
            $table->string('commitment_title')->default('Building An Empowered Generation For Tomorrow');
            $table->text('commitment_description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('principal_messages', function (Blueprint $table): void {
            $table->id();
            $table->string('desk_title')->default('FROM THE DESK OF');
            $table->string('desk_subtitle')->default('The Principal, JRS International School');
            $table->string('official_address_badge')->default('OFFICIAL ADDRESS');
            $table->string('academic_year')->default('Academic Year 2026 – 2027');
            $table->string('section_badge')->default("PRINCIPAL'S MESSAGE");
            $table->string('title')->default('Empowering Minds And Enriching Lives');
            $table->string('salutation')->default('Dear Parents, Students And Well-Wishers,');
            $table->string('card_badge')->default('PRINCIPAL');
            $table->string('profile_badge')->default('ACADEMIC LEADERSHIP');
            $table->string('name')->default('Mrs. Marlene Mannas');
            $table->string('sub_title')->default('Principal, JRS International School');
            $table->string('image_path')->nullable();
            $table->text('paragraph')->nullable();
            $table->text('quote')->nullable();
            $table->string('signoff_note')->default('WARM REGARDS,');
            $table->string('signoff_signature')->default('Marlene Mannas');
            $table->string('signoff_name')->default('Mrs. Marlene Mannas');
            $table->string('signoff_sub')->default('Principal, JRS International School');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('why_choose_features', function (Blueprint $table): void {
            $table->id();
            $table->string('type')->default('card');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('icon_color')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('campus_lives', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('icon')->nullable();
            $table->string('image_path')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('about_sections', function (Blueprint $table): void {
            $table->id();
            $table->string('tagline')->default('ABOUT JRS');
            $table->string('title')->default('A Legacy Of Excellence');
            $table->string('title_highlight')->default('In Education');
            $table->text('description_p1');
            $table->text('description_p2')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->string('image_1_url')->nullable();
            $table->string('image_2_url')->nullable();
            $table->string('video_title')->default('Watch a video about how we work and try for our students');
            $table->string('video_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('home_banners', function (Blueprint $table): void {
            $table->id();
            $table->string('image_path')->nullable();
            $table->timestamps();
        });

        Schema::create('breadcrumb_banners', function (Blueprint $table): void {
            $table->id();
            $table->string('page_name');
            $table->string('page_slug');
            $table->string('breadcrumb_title');
            $table->string('title');
            $table->string('highlighted_title')->nullable();
            $table->string('background_image')->nullable();
            $table->string('subtitle')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('breadcrumb_banner_stats', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('breadcrumb_banner_id');
            $table->string('icon')->nullable();
            $table->string('value')->nullable();
            $table->string('label')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('admission_popups', function (Blueprint $table): void {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->string('image_path')->nullable();
            $table->string('badge_text')->default('ADMISSIONS OPEN');
            $table->string('cbse_affiliation_text')->nullable();
            $table->string('school_name')->nullable();
            $table->string('school_location')->nullable();
            $table->string('academic_year_badge')->nullable();
            $table->string('title_prefix')->nullable();
            $table->string('academic_year_highlight')->nullable();
            $table->text('description')->nullable();
            $table->json('features')->nullable();
            $table->string('phone_number')->nullable();
            $table->timestamps();
        });

        Schema::create('admission_banners', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('title_highlight')->nullable();
            $table->text('description')->nullable();
            $table->string('primary_button_text')->nullable();
            $table->string('primary_button_link')->nullable();
            $table->string('secondary_button_text')->nullable();
            $table->string('secondary_button_link')->nullable();
            $table->string('image_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('admission_enquiries', function (Blueprint $table): void {
            $table->id();
            $table->string('academic_year');
            $table->string('branch');
            $table->string('admission_type');
            $table->string('grade');
            $table->string('parent_mobile');
            $table->date('student_dob');
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('contact_inquiries', function (Blueprint $table): void {
            $table->id();
            $table->string('parent_name');
            $table->string('phone');
            $table->string('grade')->nullable();
            $table->string('email')->nullable();
            $table->text('message');
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
}
