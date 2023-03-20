<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\GeneralSettingController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\PricingPlanController;
use App\Http\Controllers\Admin\SupportTicketController;
use App\Http\Controllers\Admin\MailConfigurationController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\SmsGatewayController;
use App\Http\Controllers\Admin\PhoneBookController;
use App\Http\Controllers\Admin\SmsController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\AndroidApiController;
use App\Http\Controllers\Admin\ManageEmailController;
use App\Http\Controllers\Admin\OwnGroupController;
use App\Http\Controllers\Admin\OwnContactController;
use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\ManualPaymentGatewayController;
use App\Http\Controllers\Admin\WhatsappController;
use App\Http\Controllers\Admin\WhatsappDeviceController;
use App\Http\Controllers\Admin\GlobalWorldController;

Route::prefix('admin')->name('admin.')->group(function () {
	Route::get('/', [LoginController::class, 'showLogin'])->name('login');
	Route::post('authenticate', [LoginController::class, 'authenticate'])->name('authenticate');
	Route::get('logout', [LoginController::class, 'logout'])->name('logout');

	Route::get('forgot-password', [NewPasswordController::class, 'create'])->name('password.request');
	Route::post('password/email', [NewPasswordController::class, 'store'])->name('password.email');
	Route::get('password/verify/code', [NewPasswordController::class, 'passwordResetCodeVerify'])->name('password.verify.code');
	Route::post('password/code/verify', [NewPasswordController::class, 'emailVerificationCode'])->name('email.password.verify.code');

	Route::get('reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset/password', [ResetPasswordController::class, 'store'])->name('password.reset.update');

	// demo.mode
	Route::middleware(['admin','demo.mode'])->group(function () {
		//Dashboard
		Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
		Route::get('profile', [AdminController::class, 'profile'])->name('profile');
		Route::post('profile/update', [AdminController::class, 'profileUpdate'])->name('profile.update');
		Route::get('password', [AdminController::class, 'password'])->name('password');
		Route::post('password/update', [AdminController::class, 'passwordUpdate'])->name('password.update');

		//Manage Customer
		Route::get('users', [CustomerController::class, 'index'])->name('user.index');
		Route::get('user/active', [CustomerController::class, 'active'])->name('user.active');
		Route::get('user/banned', [CustomerController::class, 'banned'])->name('user.banned');
		Route::get('user/detail/{id}', [CustomerController::class, 'details'])->name('user.details');
		Route::post('user/update/{id}', [CustomerController::class, 'update'])->name('user.update');
		Route::get('user/search/{scope}', [CustomerController::class, 'search'])->name('user.search');

		Route::get('user/sms/contact/log/{id}', [CustomerController::class, 'contact'])->name('user.sms.contact');
		Route::get('user/sms/log/{id}', [CustomerController::class, 'sms'])->name('user.sms');

		Route::get('user/email/contact/log/{id}', [CustomerController::class, 'emailContact'])->name('user.email.contact');
		Route::get('user/email/log/{id}', [CustomerController::class, 'emailLog'])->name('user.email');


		//General Setting
		Route::get('general/setting', [GeneralSettingController::class, 'index'])->name('general.setting.index');
		Route::post('general/setting/store', [GeneralSettingController::class, 'store'])->name('general.setting.store');
		Route::get('general/setting/cache/clear', [GeneralSettingController::class, 'cacheClear'])->name('general.setting.cache.clear');
		Route::get('general/setting/passport/key', [GeneralSettingController::class, 'installPassportKey'])->name('general.setting.passport.key');

		Route::get('system/info', [GeneralSettingController::class, 'systemInfo'])->name('system.info');
		Route::get('social/login', [GeneralSettingController::class, 'socialLogin'])->name('general.setting.social.login');
		Route::post('social/login/update', [GeneralSettingController::class, 'socialLoginUpdate'])->name('social.login.update');
		Route::get('frontend/section', [GeneralSettingController::class, 'frontendSection'])->name('general.setting.frontend.section');
		Route::post('frontend/section/store', [GeneralSettingController::class, 'frontendSectionStore'])->name('general.setting.frontend.section.store');
		//Currency
		Route::get('general/setting/currencies', [CurrencyController::class, 'index'])->name('general.setting.currency.index');
		Route::post('general/setting/currency/store', [CurrencyController::class, 'store'])->name('general.setting.currency.store');
		Route::post('general/setting/currency/update', [CurrencyController::class, 'update'])->name('general.setting.currency.update');
		Route::post('general/setting/currency/delete', [CurrencyController::class, 'delete'])->name('general.setting.currency.delete');

		//Pricing Plan
		Route::get('plans', [PricingPlanController::class, 'index'])->name('plan.index');
		Route::post('plans/store', [PricingPlanController::class, 'store'])->name('plan.store');
		Route::post('plans/update', [PricingPlanController::class, 'update'])->name('plan.update');
		Route::post('plans/delete', [PricingPlanController::class, 'delete'])->name('plan.delete');
		Route::get('plans/subscription', [PricingPlanController::class, 'subscription'])->name('plan.subscription');
		Route::get('plans/subscription/search', [PricingPlanController::class, 'search'])->name('plan.subscription.search');
		Route::post('plans/subscription/approved', [PricingPlanController::class, 'subscriptionApproved'])->name('plan.subscription.approved');

		//Support Ticket
		Route::get('support/tickets', [SupportTicketController::class, 'index'])->name('support.ticket.index');
		Route::post('support/ticket/reply/{id}', [SupportTicketController::class, 'ticketReply'])->name('support.ticket.reply');
		Route::post('support/ticket/closed/{id}', [SupportTicketController::class, 'closedTicket'])->name('support.ticket.closeds');
		Route::get('support/running/tickets', [SupportTicketController::class, 'running'])->name('support.ticket.running');
		Route::get('support/tickets/replied', [SupportTicketController::class, 'replied'])->name('support.ticket.replied');
		Route::get('support/ticket/answered', [SupportTicketController::class, 'answered'])->name('support.ticket.answered');
		Route::get('support/ticket/closeds', [SupportTicketController::class, 'closed'])->name('support.ticket.closed');
		Route::get('support/ticket/details/{id}', [SupportTicketController::class, 'ticketDetails'])->name('support.ticket.details');
		Route::get('support/ticket/download/{id}', [SupportTicketController::class, 'supportTicketDownlode'])->name('support.ticket.download');
		Route::get('support/ticket/search/{scope}', [SupportTicketController::class, 'search'])->name('support.ticket.search');

		//Mail Configration
		Route::get('mail/configuration', [MailConfigurationController::class, 'index'])->name('mail.configuration');
		Route::post('mail/update/{id}', [MailConfigurationController::class, 'mailUpdate'])->name('mail.update');
		Route::get('mail/edit/{id}', [MailConfigurationController::class, 'edit'])->name('mail.edit');
		Route::post('mail/send/method', [MailConfigurationController::class, 'sendMailMethod'])->name('mail.send.method');
		Route::get('global/template', [MailConfigurationController::class, 'globalTemplate'])->name('mail.global.template');
		Route::post('global/template/update', [MailConfigurationController::class, 'globalTemplateUpdate'])->name('global.template.update');
		// test mail route
		Route::post('mail/test/{id}', [MailConfigurationController::class, 'mailTester'])->name('mail.test');

		//Email Templates
		Route::get('mail/templates', [EmailTemplateController::class, 'index'])->name('mail.templates.index');
		Route::get('mail/template/edit/{id}', [EmailTemplateController::class, 'edit'])->name('mail.templates.edit');
		Route::post('mail/template/update/{id}', [EmailTemplateController::class, 'update'])->name('mail.templates.update');

		//Payment Method
		Route::get('payment/methods', [PaymentMethodController::class, 'index'])->name('payment.method');
		Route::post('payment/update/{id}', [PaymentMethodController::class, 'update'])->name('payment.update');
		Route::get('payment/method/edit/{slug}/{id}', [PaymentMethodController::class, 'edit'])->name('payment.edit');


		//Manual Payment Method
		Route::get('manual/payment/methods', [ManualPaymentGatewayController::class, 'index'])->name('manual.payment.index');
		Route::get('manual/payment/create', [ManualPaymentGatewayController::class, 'create'])->name('manual.payment.create');
		Route::post('manual/payment/store', [ManualPaymentGatewayController::class, 'store'])->name('manual.payment.store');
		Route::get('manual/payment/edit/{id}', [ManualPaymentGatewayController::class, 'edit'])->name('manual.payment.edit');
		Route::post('manual/payment/update/{id}', [ManualPaymentGatewayController::class, 'update'])->name('manual.payment.update');
		Route::post('manual/payment/delete', [ManualPaymentGatewayController::class, 'delete'])->name('manual.payment.delete');



		//Report and logs
		Route::get('report/transactions', [ReportController::class, 'transaction'])->name('report.transaction.index');
		Route::get('report/transactions/search', [ReportController::class, 'transactionSearch'])->name('report.transaction.search');
		Route::get('report/sms/credits', [ReportController::class, 'credit'])->name('report.credit.index');
		Route::get('report/sms/credit/search', [ReportController::class, 'creditSearch'])->name('report.credit.search');

		Route::get('report/email/credits', [ReportController::class, 'emailCredit'])->name('report.email.credit.index');
		Route::get('report/email/credit/search', [ReportController::class, 'emailCreditSearch'])->name('report.email.credit.search');

		Route::get('report/payment/log', [ReportController::class, 'paymentLog'])->name('report.payment.index');
		Route::get('report/payment/detail/{id}', [ReportController::class, 'paymentDetail'])->name('report.payment.detail');
		Route::post('report/payment/approve', [ReportController::class, 'approve'])->name('report.payment.approve');
		Route::post('report/payment/reject', [ReportController::class, 'reject'])->name('report.payment.reject');


		Route::get('report/payment/search', [ReportController::class, 'paymentLogSearch'])->name('report.payment.search');
		Route::get('report/subscriptions', [ReportController::class, 'subscription'])->name('report.subscription.index');
		Route::get('report/subscription/search', [ReportController::class, 'subscriptionSearch'])->name('report.subscription.search');

		//SMS Gateway
		Route::get('sms/gateway', [SmsGatewayController::class, 'index'])->name('gateway.sms.index');
		Route::get('sms/gateway/edit/{id}', [SmsGatewayController::class, 'edit'])->name('gateway.sms.edit');
		Route::post('sms/gateway/update/{id}', [SmsGatewayController::class, 'update'])->name('sms.gateway.update');
		Route::post('sms/default/gateway', [SmsGatewayController::class, 'defaultGateway'])->name('sms.default.gateway');

		//whatsapp Gateway
		Route::get('whatsapp/gateway/create', [WhatsappDeviceController::class, 'create'])->name('gateway.whatsapp.create');
		Route::post('whatsapp/gateway/create', [WhatsappDeviceController::class, 'store']);
		Route::get('whatsapp/gateway/edit/{id}', [WhatsappDeviceController::class, 'edit'])->name('gateway.whatsapp.edit');
		Route::post('whatsapp/gateway/update', [WhatsappDeviceController::class, 'update'])->name('gateway.whatsapp.update');
		Route::post('whatsapp/gateway/status-update', [WhatsappDeviceController::class, 'statusUpdate'])->name('gateway.whatsapp.status-update');
		Route::post('whatsapp/gateway/delete', [WhatsappDeviceController::class, 'delete'])->name('gateway.whatsapp.delete');
		Route::post('whatsapp/gateway/qr-code', [WhatsappDeviceController::class, 'getWaqr'])->name('gateway.whatsapp.qrcode');

		//group
		Route::get('sms/groups', [PhoneBookController::class, 'smsGroupIndex'])->name('group.sms.index');
		Route::get('sms/group/contact/{id}', [PhoneBookController::class, 'smsContactByGroup'])->name('group.sms.groupby');
		Route::get('email/groups', [PhoneBookController::class, 'emailGroupIndex'])->name('group.email.index');
		Route::get('email/contact/{id}', [PhoneBookController::class, 'emailContactByGroup'])->name('group.email.groupby');

		Route::get('sms/own/groups', [OwnGroupController::class, 'smsIndex'])->name('group.own.sms.index');
		Route::post('sms/own/group/store', [OwnGroupController::class, 'smsStore'])->name('group.own.sms.store');
		Route::post('sms/own/group/update', [OwnGroupController::class, 'smsUpdate'])->name('group.own.sms.update');
		Route::post('sms/own/group/delete', [OwnGroupController::class, 'smsDelete'])->name('group.own.sms.delete');
		Route::get('sms/own/group/contact/{id}', [OwnGroupController::class, 'smsOwnContactByGroup'])->name('group.own.sms.contact');

		Route::get('email/own/groups', [OwnGroupController::class, 'emailIndex'])->name('group.own.email.index');
		Route::post('email/own/group/store', [OwnGroupController::class, 'emailStore'])->name('group.own.email.store');
		Route::post('email/own/group/update', [OwnGroupController::class, 'emailUpdate'])->name('group.own.email.update');
		Route::post('email/own/group/delete', [OwnGroupController::class, 'emailDelete'])->name('group.own.email.delete');
		Route::get('email/own/group/contact/{id}', [OwnGroupController::class, 'emailOwnContactByGroup'])->name('group.own.email.contact');

		//Contact
		Route::get('email/own/contacts', [OwnContactController::class, 'emailContactIndex'])->name('contact.email.own.index');
		Route::post('email/own/contact/store', [OwnContactController::class, 'emailContactStore'])->name('contact.email.own.store');
		Route::post('email/own/contact/update', [OwnContactController::class, 'emailContactUpdate'])->name('contact.email.own.update');
		Route::post('email/own/contact/delete', [OwnContactController::class, 'emailContactDelete'])->name('contact.email.own.delete');
		Route::post('email/own/contact/import', [OwnContactController::class, 'emailContactImport'])->name('contact.email.own.import');
		Route::get('email/own/contact/export', [OwnContactController::class, 'emailContactExport'])->name('contact.email.own.export');

		Route::get('sms/own/contacts', [OwnContactController::class, 'smsContactIndex'])->name('contact.sms.own.index');
		Route::post('sms/own/contact/store', [OwnContactController::class, 'smsContactStore'])->name('contact.sms.own.store');
		Route::post('sms/own/contact/update', [OwnContactController::class, 'smsContactUpdate'])->name('contact.sms.own.update');
		Route::post('sms/own/contact/delete', [OwnContactController::class, 'smsContactDelete'])->name('contact.sms.own.delete');
		Route::post('sms/own/contact/import', [OwnContactController::class, 'smsContactImport'])->name('contact.sms.own.import');
		Route::get('sms/own/contact/export', [OwnContactController::class, 'smsContactExport'])->name('contact.sms.own.export');




		Route::get('sms/contacts', [PhoneBookController::class, 'smsContactIndex'])->name('contact.sms.index');
		Route::get('email/contacts', [PhoneBookController::class, 'emailContactIndex'])->name('contact.email.index');

		Route::get('sms/contact/export', [PhoneBookController::class, 'contactExport'])->name('contact.sms.export');
		Route::get('email/contact/export', [PhoneBookController::class, 'emailContactExport'])->name('contact.email.export');

		//sms log
		Route::get('sms/create', [SmsController::class, 'create'])->name('sms.create');
		Route::post('sms/store', [SmsController::class, 'store'])->name('sms.store');
		Route::get('sms', [SmsController::class, 'index'])->name('sms.index');
		Route::get('sms/pending', [SmsController::class, 'pending'])->name('sms.pending');
		Route::get('sms/delivered', [SmsController::class, 'success'])->name('sms.success');
		Route::get('sms/schedule', [SmsController::class, 'schedule'])->name('sms.schedule');
		Route::get('sms/failed', [SmsController::class, 'failed'])->name('sms.failed');
		Route::get('sms/processing', [SmsController::class, 'processing'])->name('sms.processing');
		Route::get('sms/search/{scope}', [SmsController::class, 'search'])->name('sms.search');
		Route::post('sms/status/update', [SmsController::class, 'smsStatusUpdate'])->name('sms.status.update');
		Route::post('sms/delete', [SmsController::class, 'delete'])->name('sms.delete');

		//Whatsapp log
		Route::get('whatsapp/create', [WhatsappController::class, 'create'])->name('whatsapp.create');
		Route::post('whatsapp/store', [WhatsappController::class, 'store'])->name('whatsapp.store');
		Route::get('whatsapp', [WhatsappController::class, 'index'])->name('whatsapp.index');
		Route::get('whatsapp/pending', [WhatsappController::class, 'pending'])->name('whatsapp.pending');
		Route::get('whatsapp/delivered', [WhatsappController::class, 'success'])->name('whatsapp.success');
		Route::get('whatsapp/schedule', [WhatsappController::class, 'schedule'])->name('whatsapp.schedule');
		Route::get('whatsapp/failed', [WhatsappController::class, 'failed'])->name('whatsapp.failed');
		Route::get('whatsapp/processing', [WhatsappController::class, 'processing'])->name('whatsapp.processing');
		Route::get('whatsapp/search/{scope}', [WhatsappController::class, 'search'])->name('whatsapp.search');
		Route::post('whatsapp/status/update', [WhatsappController::class, 'smsStatusUpdate'])->name('whatsapp.status.update');
		Route::post('whatsapp/delete', [WhatsappController::class, 'delete'])->name('whatsapp.delete');

		//Email log
		Route::get('email/send', [ManageEmailController::class, 'create'])->name('email.send');
		Route::post('email/store', [ManageEmailController::class, 'store'])->name('email.store');
		Route::get('email', [ManageEmailController::class, 'index'])->name('email.index');
		Route::get('email/pending', [ManageEmailController::class, 'pending'])->name('email.pending');
		Route::get('email/delivered', [ManageEmailController::class, 'success'])->name('email.success');
		Route::get('email/schedule', [ManageEmailController::class, 'schedule'])->name('email.schedule');
		Route::get('email/failed', [ManageEmailController::class, 'failed'])->name('email.failed');
		Route::get('email/search/{scope}', [ManageEmailController::class, 'search'])->name('email.search');
		Route::post('email/status/update', [ManageEmailController::class, 'emailStatusUpdate'])->name('email.status.update');
		Route::get('email/single/mail/send/{id}', [ManageEmailController::class, 'emailSend'])->name('email.single.mail.send');
		Route::get('email/view/{id}', [ManageEmailController::class, 'viewEmailBody'])->name('email.view');
		Route::post('email/delete', [ManageEmailController::class, 'delete'])->name('email.delete');


		//android gateway
		Route::get('android/gateway', [AndroidApiController::class, 'index'])->name('gateway.sms.android.index');
		Route::post('android/gateway/store', [AndroidApiController::class, 'store'])->name('gateway.sms.android.store');
		Route::post('android/gateway/update', [AndroidApiController::class, 'update'])->name('gateway.sms.android.update');
		Route::get('android/gateway/sim/list/{id}', [AndroidApiController::class, 'simList'])->name('gateway.sms.android.sim.index');
		Route::post('android/gateway/delete/', [AndroidApiController::class, 'delete'])->name('gateway.sms.android.delete');
		Route::post('android/gateway/sim/delete/', [AndroidApiController::class, 'simNumberDelete'])->name('gateway.sms.android.sim.delete');

		//Template
		Route::get('sms/templates', [TemplateController::class, 'index'])->name('template.index');
		Route::post('sms/template/store', [TemplateController::class, 'store'])->name('template.store');
		Route::post('sms/template/update', [TemplateController::class, 'update'])->name('template.update');
		Route::post('sms/template/delete', [TemplateController::class, 'delete'])->name('template.delete');
		// user template
		Route::get('sms/user/templates', [TemplateController::class, 'userIndex'])->name('template.user.index');
		Route::post('sms/template/user/status', [TemplateController::class, 'updateStatus'])->name('template.userStatus.update');
		//Language
		Route::get('languages', [LanguageController::class, 'index'])->name('language.index');
		Route::post('language/store', [LanguageController::class, 'store'])->name('language.store');
		Route::post('language/update', [LanguageController::class, 'update'])->name('language.update');
		Route::get('language/translate/{code}', [LanguageController::class, 'translate'])->name('language.translate');
		Route::post('language/data/store', [LanguageController::class, 'languageDataStore'])->name('language.data.store');
		Route::post('language/data/update', [LanguageController::class, 'languageDataUpdate'])->name('language.data.update');
		Route::post('language/delete', [LanguageController::class, 'languageDelete'])->name('language.delete');
		Route::post('language/data/delete', [LanguageController::class, 'languageDataUpDelete'])->name('language.data.delete');
		Route::post('language/default', [LanguageController::class, 'setDefaultLang'])->name('language.default');

        // Global world
		Route::get('global/world', [GlobalWorldController::class, 'index'])->name('global.world.index');
		Route::post('global/world/store', [GlobalWorldController::class, 'store'])->name('global.world.store');
		Route::post('global/world/update', [GlobalWorldController::class, 'update'])->name('global.world.update');
		Route::post('global/world/delete', [GlobalWorldController::class, 'delete'])->name('global.world.delete');
	});
});
