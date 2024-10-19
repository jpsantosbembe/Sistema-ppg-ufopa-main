<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/dashboard2',fn()=>Inertia::render('dashboard/dashboard2'))->name('dashboard.1');

Route::get('/ecommerce/products-one',fn()=>Inertia::render('apps/eCommerce/ProductsOne'))->name('e-commerce.shop.one');
Route::get('/ecommerce/products-two',fn()=>Inertia::render('apps/eCommerce/ProductsTwo'))->name('e-commerce.shop.two');
Route::get('/ecommerce/product/detail/one/{id}',fn($id)=>Inertia::render('apps/eCommerce/ProductDetailsOne'))->name('e-commerce.shop.detail.one');
Route::get('/ecommerce/product/detail/two/{id}',fn($id)=>Inertia::render('apps/eCommerce/ProductDetails'))->name('e-commerce.shop.detail.two');
Route::get('/ecommerce/productlist',fn()=>Inertia::render('apps/eCommerce/ProductList'))->name('e-commerce.list');
Route::get('/ecommerce/checkout',fn()=>Inertia::render('apps/eCommerce/ProductCheckout'))->name('e-commerce.checkout');



Route::prefix('/apps')->group(function (){
    Route::get('/contacts',fn()=>Inertia::render('apps/contact/Contact'))->name('apps.contact');
    Route::get('/blog/posts',fn()=>Inertia::render('apps/blog/Posts'))->name('apps.blog.post');
    Route::get('/blog/{id}',fn($id)=>Inertia::render('apps/blog/Detail'))->name('apps.blog.detail');
    Route::get('/chats',fn()=>Inertia::render('apps/chat/Chats'))->name('apps.chat');
    Route::get('/user/profileone',fn()=>Inertia::render('apps/user-profile/profile-one/ProfileOne'))->name('apps.user.profile.one');
    Route::get('/user/profiletwo',fn()=>Inertia::render('apps/user-profile/profile-two/ProfileTwo'))->name('apps.suser.profile.two');
    Route::get('/notes',fn()=>Inertia::render('apps/notes/Notes'))->name('apps.notes');
    Route::get('/calendar',fn()=>Inertia::render('apps/calendar/Calendar'))->name('apps.calendar');
    Route::get('/kanban',fn()=>Inertia::render('apps/kanban/Kanban'))->name('apps.kanban');

});

Route::prefix('/pages')->group(function (){
    Route::get('/pricing',fn()=>Inertia::render('pages/pricing/Pricing'))->name('pages.pricing');
    Route::get('/faq',fn()=>Inertia::render('pages/faq/Faq'))->name('pages.faq');
    Route::get('/account-settings',fn()=>Inertia::render('pages/account-settings/AccountSettings'))->name('pages.account-settings');
});

Route::prefix('/widgets')->group(function (){
    Route::get('/banners',fn()=>Inertia::render('widgets/banners/banners'))->name('widgets.banners');
    Route::get('/cards',fn()=>Inertia::render('widgets/cards/cards'))->name('widgets.cards');
    Route::get('/charts',fn()=>Inertia::render('widgets/charts/charts'))->name('widgets.charts');
});

Route::prefix('/teachers')->group(function (){
    Route::get('/all-teachers',fn()=>Inertia::render('school-pages/teachers/Teachers'))->name('teachers.all-teachers');
    Route::get('/teachers-details',fn()=>Inertia::render('school-pages/teachers/TeachersDetails'))->name('teachers.teachers-details');
});

Route::prefix('/exam')->group(function (){
    Route::get('/exam-schedule',fn()=>Inertia::render('school-pages/exam/ExamSchedule'))->name('exam.exam-schedule');
    Route::get('/exam-result',fn()=>Inertia::render('school-pages/exam/ExamResults'))->name('exam.exam-result');
    Route::get('/exam-result-details',fn()=>Inertia::render('school-pages/exam/ExamResultsDetail'))->name('exam.exam-result.details');
});

Route::prefix('/students')->group(function (){
    Route::get('/all-students',fn()=>Inertia::render('school-pages/students/Students'))->name('students.all-students');
    Route::get('/students-details',fn()=>Inertia::render('school-pages/students/StudentsDetails'))->name('students.students-details');
});

Route::get('/school-pages/classes',fn()=>Inertia::render('school-pages/classes/Classes'))->name('classes');
Route::get('/school-pages/classes/details/{id}',fn($id)=>Inertia::render('school-pages/classes/ClassDetail'))->name('classes.details');
Route::get('/school-pages/attendance',fn()=>Inertia::render('school-pages/attendence/index'))->name('attendance');

Route::prefix('/ui-components')->group(function (){
    Route::get('/alert',fn()=>Inertia::render('ui-elements/UiAlert'))->name('ui.alert');
    Route::get('/accordion',fn()=>Inertia::render('ui-elements/UiExpansionPanel'))->name('ui.accordion');
    Route::get('/avatar',fn()=>Inertia::render('ui-elements/UiAvatar'))->name('ui.avatar');
    Route::get('/chip',fn()=>Inertia::render('ui-elements/UiChip'))->name('ui.chip');
    Route::get('/dialogs',fn()=>Inertia::render('ui-elements/UiDialog'))->name('ui.dialogs');
    Route::get('/list',fn()=>Inertia::render('ui-elements/UiList'))->name('ui.list');
    Route::get('/menus',fn()=>Inertia::render('ui-elements/UiMenus'))->name('ui.menus');
    Route::get('/rating',fn()=>Inertia::render('ui-elements/UiRating'))->name('ui.rating');
    Route::get('/tabs',fn()=>Inertia::render('ui-elements/UiTabs'))->name('ui.tabs');
    Route::get('/tooltip',fn()=>Inertia::render('ui-elements/UiTooltip'))->name('ui.tooltip');
    Route::get('/typography',fn()=>Inertia::render('style-animation/Typography'))->name('ui.typography');
});

Route::prefix('/forms')->group(function (){
    Route::get('/form-elements/autocomplete',fn()=>Inertia::render('forms/form-elements/VAutocomplete'))->name('form.elements.autocomplete');
    Route::get('/form-elements/combobox',fn()=>Inertia::render('forms/form-elements/Combobox'))->name('form.elements.combobox');
    Route::get('/form-elements/fileinputs',fn()=>Inertia::render('forms/form-elements/FileInputs'))->name('form.elements.fileinputs');
    Route::get('/form-elements/custominputs',fn()=>Inertia::render('forms/form-elements/CustomInputs'))->name('form.elements.custominputs');
    Route::get('/form-elements/select',fn()=>Inertia::render('forms/form-elements/Select'))->name('form.elements.select');
    Route::get('/form-elements/button',fn()=>Inertia::render('forms/form-elements/VButtons'))->name('form.elements.button');
    Route::get('/form-elements/radio',fn()=>Inertia::render('forms/form-elements/VRadio'))->name('form.elements.radio');
    Route::get('/form-elements/date-time',fn()=>Inertia::render('forms/form-elements/VDateTime'))->name('form.elements.date-time');
    Route::get('/form-elements/slider',fn()=>Inertia::render('forms/form-elements/VSlider'))->name('form.elements.slider');
    Route::get('/form-elements/switch',fn()=>Inertia::render('forms/form-elements/VSwitch'))->name('form.elements.switch');
    Route::get('/input/form-layouts',fn()=>Inertia::render('forms/FormLayouts'))->name('form.input.form-layouts');
    Route::get('/input/form-horizontal',fn()=>Inertia::render('forms/FormHorizontal'))->name('form.input.form-horizontal');
    Route::get('/input/form-vertical',fn()=>Inertia::render('forms/FormVertical'))->name('form.input.form-vertical');
    Route::get('/input/form-custom',fn()=>Inertia::render('forms/FormCustom'))->name('form.input.form-custom');
    Route::get('/input/form-validation',fn()=>Inertia::render('forms/FormValidation'))->name('form.input.form-validation');
    Route::get('/input/editor',fn()=>Inertia::render('forms/plugins/editor/Editor'))->name('form.input.editor');

});

Route::prefix('/tables')->group(function (){
    Route::get('/basic',fn()=>Inertia::render('tables/TableBasic'))->name('tables.basic');
    Route::get('/dark',fn()=>Inertia::render('tables/TableDark'))->name('tables.dark');
    Route::get('/density',fn()=>Inertia::render('tables/TableDensity'))->name('tables.density');
    Route::get('/fixed-header',fn()=>Inertia::render('tables/TableHeaderFixed'))->name('tables.fixed-header');
    Route::get('/height',fn()=>Inertia::render('tables/TableHeight'))->name('tables.height');
    Route::get('/editable',fn()=>Inertia::render('tables/TableEditable'))->name('tables.editable');
    Route::get('/editable',fn()=>Inertia::render('tables/TableEditable'))->name('tables.editable');
    Route::prefix('/datatables')->group(function (){
        Route::get('/basic',fn()=>Inertia::render('tables/datatables/BasicTable'))->name('tables.datatables.basic');
        Route::get('/header',fn()=>Inertia::render('tables/datatables/HeaderTables'))->name('tables.datatables.header');
        Route::get('/selection',fn()=>Inertia::render('tables/datatables/Selectable'))->name('tables.datatables.selection');
        Route::get('/sorting',fn()=>Inertia::render('tables/datatables/SortingTable'))->name('tables.datatables.sorting');
        Route::get('/pagination',fn()=>Inertia::render('tables/datatables/Pagination'))->name('tables.datatables.pagination');
        Route::get('/filtering',fn()=>Inertia::render('tables/datatables/Filtering'))->name('tables.datatables.filtering');
        Route::get('/grouping',fn()=>Inertia::render('tables/datatables/Grouping'))->name('tables.datatables.grouping');
        Route::get('/slots',fn()=>Inertia::render('tables/datatables/Slots'))->name('tables.datatables.slots');
    });
});

Route::get('/icons/tabler',fn()=>Inertia::render('icons/TablerIcons'))->name('icon.tabler');


Route::prefix('/charts')->group(function (){
    Route::get('/line-chart',fn()=>Inertia::render('charts/ApexLineChart'))->name('charts.line');
    Route::get('/column-chart',fn()=>Inertia::render('charts/ApexColumnChart'))->name('charts.column');
    Route::get('/area-chart',fn()=>Inertia::render('charts/ApexAreaChart'))->name('charts.area');
    Route::get('/gredient-chart',fn()=>Inertia::render('charts/ApexGredientChart'))->name('charts.gredient');
    Route::get('/candlestick-chart',fn()=>Inertia::render('charts/ApexCandlestickChart'))->name('charts.candlestick-chart');
    Route::get('/doughnut-pie-chart',fn()=>Inertia::render('charts/ApexDonutPieChart'))->name('charts.doughnut-pie');
    Route::get('/radialbar-chart',fn()=>Inertia::render('charts/ApexRadialRadarChart'))->name('charts.radialbar');
    Route::get('/radialbar-chart',fn()=>Inertia::render('charts/ApexRadialRadarChart'))->name('charts.radialbar');
});

Route::prefix('/auth')->group(function (){
    Route::get('/login',fn()=>Inertia::render('authentication/SideLogin'));
    Route::get('/login2',fn()=>Inertia::render('authentication/BoxedLogin'));
    Route::get('/register',fn()=>Inertia::render('authentication/SideRegister'));
    Route::get('/register2',fn()=>Inertia::render('authentication/SideForgotPassword'));
    Route::get('/forgot-password',fn()=>Inertia::render('authentication/SideForgotPassword'));
    Route::get('/forgot-password2',fn()=>Inertia::render('authentication/BoxedForgotPassword'));
    Route::get('/two-step',fn()=>Inertia::render('authentication/SideTwoStep'));
    Route::get('/two-step2',fn()=>Inertia::render('authentication/BoxedTwoStep'));
    Route::get('/404',fn()=>Inertia::render('authentication/Error'));
    Route::get('/maintenance',fn()=>Inertia::render('authentication/Maintenance'));
});

Route::prefix('/outhers')->group(function (){
    Route::get('/login',fn()=>Inertia::render('authentication/SideLogin'));
    Route::get('/login2',fn()=>Inertia::render('authentication/BoxedLogin'));
    Route::get('/register',fn()=>Inertia::render('authentication/SideRegister'));
    Route::get('/register2',fn()=>Inertia::render('authentication/SideForgotPassword'));
    Route::get('/forgot-password',fn()=>Inertia::render('authentication/SideForgotPassword'));
    Route::get('/forgot-password2',fn()=>Inertia::render('authentication/BoxedForgotPassword'));
    Route::get('/two-step',fn()=>Inertia::render('authentication/SideTwoStep'));
    Route::get('/two-step2',fn()=>Inertia::render('authentication/BoxedTwoStep'));
    Route::get('/404',fn()=>Inertia::render('authentication/Error'));
    Route::get('/maintenance',fn()=>Inertia::render('authentication/Maintenance'));
});
