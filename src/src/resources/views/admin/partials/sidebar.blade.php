<div id="sideContent" class="side_content">
    <div class="logo_container">
        <div class="logo_name">
            <div class="logo_img">
                <img src="{{showImage(filePath()['site_logo']['path'].'/site_logo.png')}}" class="h-100 mx-auto" alt="">
                <div onclick="showSideBar()" class="cross">
                    <i class="lar la-times-circle fs--9 text--light"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="side_bar_menu_container">
        <div class="side_bar_menu_list">
            <ul>
                <!-- Dashboard -->
                <li class="side_bar_list d--flex align--center">
                    <a class="ms--1 d--flex align--center {{menuActive('admin.dashboard')}}" href="{{route('admin.dashboard')}}">
                        <div>
                            <span class="me-3"><i class="fs-5 las la-home text--light me-2"></i></span> {{ translate('Dashboard')}}
                        </div>
                    </a>
                </li>
                <!-- SMS Options -->
                <li>
                    <a class="ms--1 d--flex align--center {{sidebarMenuActive(['admin.sms.index','admin.sms.pending','admin.sms.success','admin.sms.failed','admin.sms.schedule', 'admin.sms.search', 'admin.sms.date.search', 'admin.sms.create', 'admin.sms.processing'])}} side_bar_first_list" href="javascript:void(0)"><div><span class="me-4"><i class="fs-5 las las la-envelope text--light"></i></span> {{ translate('SMS Options')}}</div>
                        <div>
                            @if($pending_sms_count > 0)
                                <i class="las la-exclamation sidebar-batch-icon"></i>
                            @endif
                            <i class="las la-angle-down icon1"></i>
                        </div>
                    </a>
                    <ul class="first_first_child {{menuActive('admin.sms*',1)}}">
                         <li>
                            <a class="{{menuActive('admin.sms.create')}}" href="{{route('admin.sms.create')}}"><i class="lab la-jira me-3"></i> {{ translate('Send SMS')}}</a>

                            <a class="{{menuActive('admin.sms.index')}}" href="{{route('admin.sms.index')}}"><i class="lab la-jira me-3"></i> {{ translate('All SMS')}}</a>

                            <a class="{{menuActive('admin.sms.pending')}}" href="{{route('admin.sms.pending')}}"><i class="lab la-jira me-3"></i> {{ translate('Pending SMS')}}
                                @if($pending_sms_count > 0)
                                    <span class="badge bg-danger"> {{$pending_sms_count}}</span>
                                @endif
                            </a>

                            <a class="{{menuActive('admin.sms.success')}}" href="{{route('admin.sms.success')}}"><i class="lab la-jira me-3"></i> {{ translate('Delivered SMS')}}</a>

                            <a class="{{menuActive('admin.sms.schedule')}}" href="{{route('admin.sms.schedule')}}"><i class="lab la-jira me-3"></i> {{ translate('Schedule SMS')}}</a>

                            <a class="{{menuActive('admin.sms.processing')}}" href="{{route('admin.sms.processing')}}"><i class="lab la-jira me-3"></i> {{ translate('Processing SMS')}}</a>

                            <a class="{{menuActive('admin.sms.failed')}}" href="{{route('admin.sms.failed')}}"><i class="lab la-jira me-3"></i> {{ translate('Failed SMS')}}</a>
                        </li>
                    </ul>
                </li>
                 <!-- Whatsapp Options -->
                 <li>
                    <a class="ms--1 d--flex align--center {{sidebarMenuActive(['admin.whatsapp.index','admin.whatsapp.pending','admin.whatsapp.success','admin.whatsapp.failed','admin.whatsapp.schedule', 'admin.whatsapp.search', 'admin.whatsapp.date.search', 'admin.whatsapp.create', 'admin.whatsapp.processing'])}} side_bar_first_list_twenty_four" href="javascript:void(0)"><div><span class="me-4"><i class="fs-5 fab fa-whatsapp text--light"></i></span> {{ translate('WhatsApp Options')}}</div>
                        <div>
                            @if($pending_whatsapp_count > 0)
                                <i class="las la-exclamation sidebar-batch-icon"></i>
                            @endif
                            <i class="las la-angle-down icon24"></i>
                        </div>
                    </a>
                    <ul class="first_first_child_twenty_four {{menuActive('admin.whatsapp*',24)}}">
                         <li>
                            <a class="{{menuActive('admin.whatsapp.create')}}" href="{{route('admin.whatsapp.create')}}"><i class="lab la-jira me-3"></i> {{ translate('Send Message')}}</a>

                            <a class="{{menuActive('admin.whatsapp.index')}}" href="{{route('admin.whatsapp.index')}}"><i class="lab la-jira me-3"></i> {{ translate('All Message')}}</a>

                            <a class="{{menuActive('admin.whatsapp.pending')}}" href="{{route('admin.whatsapp.pending')}}"><i class="lab la-jira me-3"></i> {{ translate('Pending Message')}}
                                @if($pending_whatsapp_count > 0)
                                    <span class="badge bg-danger"> {{$pending_whatsapp_count}}</span>
                                @endif
                            </a>

                            <a class="{{menuActive('admin.whatsapp.success')}}" href="{{route('admin.whatsapp.success')}}"><i class="lab la-jira me-3"></i> {{ translate('Delivered Message')}}</a>

                            <a class="{{menuActive('admin.whatsapp.schedule')}}" href="{{route('admin.whatsapp.schedule')}}"><i class="lab la-jira me-3"></i> {{ translate('Schedule Message')}}</a>

                            <a class="{{menuActive('admin.whatsapp.processing')}}" href="{{route('admin.whatsapp.processing')}}"><i class="lab la-jira me-3"></i> {{ translate('Processing Message')}}</a>

                            <a class="{{menuActive('admin.whatsapp.failed')}}" href="{{route('admin.whatsapp.failed')}}"><i class="lab la-jira me-3"></i> {{ translate('Failed Message')}}</a>
                        </li>
                    </ul>
                </li>
                <!-- EMAIL Options -->
                <li>
                    <a class="ms--1 d--flex align--center {{sidebarMenuActive(['admin.email.index','admin.email.pending','admin.email.success','admin.email.failed','admin.email.schedule', 'admin.email.search', 'admin.email.date.search', 'admin.email.send'])}} side_bar_second_list" href="javascript:void(0)"><div><span class="me-4"><i class="fs-5 las las la-envelope-open-text text--light"></i></span> {{ translate('Email Options')}}</div>
                        <div>
                            @if($pending_email_count > 0)
                                <i class="las la-exclamation sidebar-batch-icon"></i>
                            @endif
                            <i class="las la-angle-down icon2"></i>
                        </div>
                    </a>
                    <ul class="first_second_child {{menuActive('admin.email*',2)}}">
                        <li>
                            <a class="{{menuActive('admin.email.send')}}" href="{{route('admin.email.send')}}"><i class="lab la-jira me-3"></i> {{ translate('Send Email')}}</a>

                            <a class="{{menuActive('admin.email.index')}}" href="{{route('admin.email.index')}}"><i class="lab la-jira me-3"></i> {{ translate('All Email')}}</a>

                            <a class="{{menuActive('admin.email.pending')}}" href="{{route('admin.email.pending')}}"><i class="lab la-jira me-3"></i> {{ translate('Pending Email')}}
                                @if($pending_email_count > 0)
                                    <span class="badge bg-danger"> {{$pending_email_count}}</span>
                                @endif
                            </a>

                            <a class="{{menuActive('admin.email.success')}}" href="{{route('admin.email.success')}}"><i class="lab la-jira me-3"></i> {{ translate('Delivered Email')}}</a>

                            <a class="{{menuActive('admin.email.schedule')}}" href="{{route('admin.email.schedule')}}"><i class="lab la-jira me-3"></i> {{ translate('Schedule Email')}}</a>

                            <a class="{{menuActive('admin.email.failed')}}" href="{{route('admin.email.failed')}}"><i class="lab la-jira me-3"></i> {{ translate('Failed Email')}}</a>
                        </li>
                    </ul>
                </li>
            </ul>


            <h1 class="text--light ms--1 mb-2"> {{ translate('USER OPTIONS')}}</h1>
            <ul>
                <li>
                    <a class="ms--1 d--flex align--center {{sidebarMenuActive(['admin.user.index', 'admin.user.active', 'admin.user.banned', 'admin.user.details', 'admin.user.search', 'admin.user.sms.contact', 'admin.user.sms', 'admin.user.email.contact','admin.user.email'])}} side_bar_third_list" href="javascript:void(0)"><div><span class="me-4"><i class="fs-5 las la-user-plus text--light"></i></span> {{ translate('Manage User')}}</div><i class="las la-angle-down icon3"></i></a>
                    <ul class="first_third_child {{menuActive('admin.user*',3)}}">
                        <li>
                            <a class="{{menuActive(['admin.user.index', 'admin.user.details', 'admin.user.search', 'admin.user.contact', 'admin.user.sms', 'admin.user.subscription'])}}" href="{{route('admin.user.index')}}"><i class="lab la-jira me-3"></i> {{ translate('All user')}}</a>
                            <a class="{{menuActive('admin.user.active')}}" href="{{route('admin.user.active')}}"><i class="lab la-jira me-3"></i> {{ translate('Active User')}}</a>
                            <a class="{{menuActive('admin.user.banned')}}" href="{{route('admin.user.banned')}}"><i class="lab la-jira me-3"></i> {{ translate('Banned User')}}</a>
                        </li>
                    </ul>
                </li>
                <li class="side_bar_list d--flex align--center">
                    <a class="ms--1 d--flex align--center {{menuActive('admin.plan.index')}}" href="{{route('admin.plan.index')}}">
                        <div>
                            <span class="me-3"><i class="fs-5 las la-paper-plane text--light me-2"></i></span> {{ translate('Pricing Plan')}}
                        </div>
                    </a>
                </li>
            </ul>
            <h1 class="text--light ms--1 mb-2"> {{ translate('GROUP & CONTACTS')}}</h1>
            <ul>
                <li>
                    <a class="ms--1 d--flex align--center {{sidebarMenuActive(['admin.group.sms.index', 'admin.group.email.index', 'admin.group.sms.groupby','admin.group.email.groupby','admin.group.own.sms.index', 'admin.group.own.email.index', 'admin.group.own.sms.contact', 'admin.group.own.email.contact'])}} side_bar_fourth_list" href="javascript:void(0)"><div><span class="me-4"><i class="fs-5 las la-bars text--light"></i></span> {{ translate('Manage Group')}}</div><i class="las la-angle-down icon4"></i></a>
                    <ul class="first_fourth_child {{menuActive('admin.group*',4)}}">
                        <li>
                            <a class="{{menuActive(['admin.group.own.sms.index', 'admin.group.sms.groupby'])}}" href="{{route('admin.group.own.sms.index')}}"><i class="lab la-jira me-3"></i> {{ translate('Own SMS Group')}}</a>
                            <a class="{{menuActive(['admin.group.own.email.index','admin.group.email.groupby'])}}" href="{{route('admin.group.own.email.index')}}"><i class="lab la-jira me-3"></i> {{ translate('Own Email Group')}}</a>

                            <a class="{{menuActive(['admin.group.sms.index', 'admin.group.sms.groupby'])}}" href="{{route('admin.group.sms.index')}}"><i class="lab la-jira me-3"></i> {{ translate('User SMS Group')}}</a>
                            <a class="{{menuActive(['admin.group.email.index', 'admin.group.email.groupby'])}}" href="{{route('admin.group.email.index')}}"><i class="lab la-jira me-3"></i> {{ translate('User Email Group')}}</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="ms--1 d--flex align--center {{sidebarMenuActive(['admin.contact.sms.index','admin.contact.email.index', 'admin.contact.email.own.index', 'admin.contact.sms.own.index'])}} side_bar_fivth_list" href="javascript:void(0)"><div><span class="me-4"><i class="fs-5 las la-comments-dollar text--light"></i></span> {{ translate('Manage Contact')}}</div><i class="las la-angle-down icon5"></i></a>
                    <ul class="first_fivth_child {{menuActive('admin.contact*',5)}}">
                        <li>
                            <a class="{{menuActive('admin.contact.email.own.index')}}" href="{{route('admin.contact.email.own.index')}}"><i class="lab la-jira me-3"></i> {{ translate('Own Email Contact')}}</a>
                            <a class="{{menuActive('admin.contact.sms.own.index')}}" href="{{route('admin.contact.sms.own.index')}}"><i class="lab la-jira me-3"></i> {{ translate('Own SMS Contact')}}</a>

                            <a class="{{menuActive('admin.contact.email.index')}}" href="{{route('admin.contact.email.index')}}"><i class="lab la-jira me-3"></i> {{ translate('User Email Contact')}}</a>
                            <a class="{{menuActive('admin.contact.sms.index')}}" href="{{route('admin.contact.sms.index')}}"><i class="lab la-jira me-3"></i> {{ translate('User SMS Contact')}}</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <h1 class="text--light ms--1 mb-2"> {{ translate('SETTINGS')}}</h1>
            <ul>
                <!-- SMS Settings -->
                <li>
                    <a class="ms--1 d--flex align--center {{sidebarMenuActive(['admin.gateway.sms.index','admin.gateway.sms.edit','admin.gateway.sms.android.index', 'admin.gateway.sms.android.sim.index'])}} side_bar_sixth_list" href="javascript:void(0)"><div><span class="me-4"><i class="fs-5 las la-sms text--light"></i></span> {{ translate('SMS Settings')}}</div><i class="las la-angle-down icon6"></i></a>
                    <ul class="first_sixth_child {{menuActive('admin.gateway.sms*',6)}}">
                        <li>
                            <a class="{{menuActive(['admin.gateway.sms.index','admin.gateway.sms.edit'])}}" href="{{route('admin.gateway.sms.index')}}"><i class="lab la-jira me-3"></i> {{ translate('SMS Api Gateway')}}</a>
                            <a class="{{menuActive(['admin.gateway.sms.android.index', 'admin.gateway.sms.android.sim.index'])}}" href="{{route('admin.gateway.sms.android.index')}}"><i class="lab la-jira me-3"></i> {{ translate('Android Gateway')}}</a>
                        </li>
                    </ul>
                </li>

                <!-- Whatsapp Settings -->
                <li>
                    <a class="ms--1 d--flex align--center {{sidebarMenuActive(['admin.gateway.whatsapp.edit','admin.gateway.whatsapp.create'])}} side_bar_twenty_two_list" href="javascript:void(0)"><div><span class="me-4"><i class="fs-5 fab fa-whatsapp text--light"></i></span> {{ translate('Whatsapp Settings')}}</div><i class="las la-angle-down icon22"></i></a>
                    <ul class="first_twenty_two_child {{menuActive('admin.gateway.whatsapp*',22)}}">
                        <li>
                            <a class="{{menuActive(['admin.gateway.whatsapp.edit','admin.gateway.whatsapp.create'])}}" href="{{route('admin.gateway.whatsapp.create')}}"><i class="lab la-jira me-3"></i> {{ translate('Add/View Device')}}</a>
                        </li>
                    </ul>
                </li>

                <!-- Email Settings -->
                <li>
                    <a class="ms--1 d--flex align--center {{sidebarMenuActive(['admin.mail.configuration', 'admin.mail.edit','admin.mail.global.template','admin.mail.templates.index', 'admin.mail.templates.edit'])}} side_bar_eight_list" href="javascript:void(0)"><div><span class="me-4"><i class="fs-5 las las la-envelope text--light"></i></span> {{ translate('Email Settings')}}</div><i class="las la-angle-down icon8"></i></a>
                    <ul class="first_eight_child {{menuActive('admin.mail*',8)}}">
                        <li>
                            <a class="{{menuActive(['admin.mail.configuration', 'admin.mail.edit'])}}" href="{{route('admin.mail.configuration')}}"><i class="lab la-jira me-3"></i> {{ translate('Mail Configuration')}}</a>

                            <a class=" {{menuActive(['admin.mail.global.template'])}}" href="{{route('admin.mail.global.template')}}"><i class="lab la-jira me-3"></i> {{ translate('Global Template')}}</a>

                            <a class="{{menuActive(['admin.mail.templates.index', 'admin.mail.templates.edit'])}}" href="{{route('admin.mail.templates.index')}}"><i class="lab la-jira me-3"></i> {{ translate('Mail Templates')}}</a>
                        </li>
                    </ul>
                </li>

                <!-- Messaging Template Settings -->
 
                <li>
                    <a class="ms--1 d--flex align--center {{ sidebarMenuActive(['admin.template.index', 'admin.template.user.index']) }} side_bar_twenty_six_list"
                        href="javascript:void(0)">
                        <div><span class="me-3"><i class="fs-5 las la-braille text--light me-2"></i></span>
                            {{ translate('Messaging Template')}}
                        </div>
                         <i class="las la-angle-down icon26"></i>
                    </a>
                    <ul class="first_twenty_six_child {{ menuActive('admin.template*', 26) }}">
                        <li>
                            <a class="{{ menuActive(['admin.template.index']) }}"
                                href="{{ route('admin.template.index') }}"><i
                                    class="lab la-jira me-3"></i>{{ translate('Admin Template')}}</a>

                            <a class="{{ menuActive(['admin.template.user.index']) }}" href="{{ route('admin.template.user.index') }}"><i class="lab la-jira me-3"></i>{{ translate('User Template')}}</a>
                        </li>
                    </ul>
                </li> 

                 <!-- Language Settings -->
                 <li class="side_bar_list d--flex align--center">
                    <a class="ms--1 d--flex align--center {{menuActive(['admin.language.index', 'admin.language.edit'])}}" href="{{route('admin.language.index')}}">
                        <div>
                            <span class="me-3"><i class="fs-5 las la-globe-asia text--light me-2"></i></span> {{ translate('Manage Language') }}
                        </div>
                    </a>
                </li>

                <!-- Global word -->
                <li class="side_bar_list d--flex align--center">
                    <a class="ms--1 d--flex align--center {{ menuActive(['admin.global.world.index']) }}"
                        href="{{ route('admin.global.world.index') }}">
                        <div>
                            <span class="me-3"><i
                                class="fs-5 las la-globe-asia text--light me-2"></i></span>{{ translate('Global World') }}
                        </div>
                    </a>
                </li>

                <!-- payment Gateway -->
                <li>
                    <a class="ms--1 d--flex align--center {{sidebarMenuActive(['admin.payment.method', 'admin.payment.edit','admin.manual.payment.index', 'admin.manual.payment.edit'])}} side_bar_fourteen_list" href="javascript:void(0)"><div><span class="me-4"><i class="fs-5 las la-credit-card text--light"></i></span> {{ translate('Payment Gateway')}}</div><i class="las la-angle-down icon14"></i></a>
                    <ul class="first_fourteen_child {{menuActive(['admin.payment.method', 'admin.payment.edit','admin.manual.payment.index','admin.manual.payment.edit'],14)}}">
                        <li>
                            <a class="{{menuActive(['admin.payment.method', 'admin.payment.edit'])}}" href="{{route('admin.payment.method')}}"><i class="lab la-jira me-3"></i> {{ translate('Automatic Gateway')}}</a>
                            <a class="{{menuActive(['admin.manual.payment.index', 'admin.manual.payment.edit'])}}" href="{{route('admin.manual.payment.index')}}"><i class="lab la-jira me-3"></i> {{ translate('Manual Gateway') }}</a>
                        </li>
                    </ul>
                </li>

                <!-- System Setttings -->
                <li>
                    <a class="ms--1 d--flex align--center {{sidebarMenuActive(['admin.general.setting.index', 'admin.general.setting.currency.index', 'admin.general.setting.social.login', 'admin.general.setting.frontend.section'])}} side_bar_eleven_list" href="javascript:void(0)"><div><span class="me-4"><i class="fs-5 las las la-cog text--light"></i></span> {{ translate('System Settings')}}</div><i class="las la-angle-down icon11"></i></a>
                    <ul class="first_eleven_child {{menuActive('admin.general.setting*',11)}}">
                        <li>
                            <a class="{{menuActive('admin.general.setting.index')}}" href="{{route('admin.general.setting.index')}}"><i class="lab la-jira me-3"></i> {{ translate('Setting')}}</a>

                            <a class="{{menuActive('admin.general.setting.social.login')}}" href="{{route('admin.general.setting.social.login')}}"><i class="lab la-jira me-3"></i> {{ translate('Google Login')}}</a>

                            <a class="{{menuActive('admin.general.setting.currency.index')}}" href="{{route('admin.general.setting.currency.index')}}"><i class="lab la-jira me-3"></i> {{ translate('Currencies')}}</a>

                            <a class="{{menuActive('admin.general.setting.frontend.section')}}" href="{{route('admin.general.setting.frontend.section')}}"><i class="lab la-jira me-3"></i> {{ translate('Frontend Section')}}</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <h1 class="text--light ms--1 mb-2"> {{ translate('TRANSACTIONAL REPORT')}}</h1>
            <ul>
                <li>
                    <a class="ms--1 d--flex align--center {{sidebarMenuActive(['admin.report.transaction.index','admin.report.transaction.search', 'admin.report.payment.index', 'admin.report.subscription.index', 'admin.report.subscription.search', 'admin.report.subscription.search.date','admin.report.credit.index','admin.report.credit.search','admin.report.email.credit.index','admin.report.email.credit.search', 'admin.report.payment.detail'])}} side_bar_twelve_list" href="javascript:void(0)"><div><span class="me-4"><i class="fs-5 las las la-bars text--light"></i></span> {{ translate('Report Logs')}}</div>
                        <div>
                            @if($pending_manual_payment_count > 0)
                                <i class="las la-exclamation sidebar-batch-icon"></i>
                            @endif
                            <i class="las la-angle-down icon12"></i>
                        </div>
                    </a>
                    <ul class="first_twelve_child {{menuActive('admin.report*',12)}}">
                        <li>
                            <a class="{{menuActive(['admin.report.transaction.index','admin.report.transaction.search'])}}" href="{{route('admin.report.transaction.index')}}"><i class="lab la-jira me-3"></i> {{ translate('Transaction History')}}</a>

                            <a class="{{menuActive(['admin.report.subscription.index','admin.report.subscription.search','admin.report.subscription.search.date'])}}" href="{{route('admin.report.subscription.index')}}"><i class="lab la-jira me-3"></i> {{ translate('Subscription History')}}</a>

                            <a class="{{menuActive(['admin.report.payment.index', 'admin.report.payment.detail'])}}" href="{{route('admin.report.payment.index')}}"><i class="lab la-jira me-3"></i> {{ translate('Payment History')}}
                                @if($pending_manual_payment_count > 0)
                                    <span class="badge bg-danger"> {{$pending_manual_payment_count}}</span>
                                @endif
                            </a>

                            <a class="{{menuActive(['admin.report.credit.index','admin.report.credit.search'])}}" href="{{route('admin.report.credit.index')}}"><i class="lab la-jira me-3"></i> {{ translate('SMS Credit Log')}}</a>

                            <a class="{{menuActive(['admin.report.email.credit.index','admin.report.email.credit.search'])}}" href="{{route('admin.report.email.credit.index')}}"><i class="lab la-jira me-3"></i> {{ translate('Email Credit Log')}}</a>
                        </li>

                    </ul>
                </li>
            </ul>

            <h1 class="text--light ms--1 mb-2"> {{ translate('SUPPORT & OTHERS')}}</h1>
            <ul>
                <li>
                    <a class="ms--1 d--flex align--center {{sidebarMenuActive(['admin.support.ticket.index', 'admin.support.ticket.running', 'admin.support.ticket.answered', 'admin.support.ticket.closed', 'admin.support.ticket.details', 'admin.support.ticket.replied', 'admin.support.ticket.search'])}} side_bar_thirty_list" href="javascript:void(0)"><div><span class="me-4"><i class="fs-5 las las la-reply text--light"></i></span> {{ translate('Support Ticket')}}
                        </div>
                        <div>
                            @if($running_support_ticket_count > 0)
                                <i class="las la-exclamation sidebar-batch-icon"></i>
                            @endif
                            <i class="las la-angle-down icon13"></i>
                        </div>
                    </a>
                    <ul class="first_thirty_child {{menuActive('admin.support.ticket*',13)}}">
                        <li>
                            <a class="{{menuActive(['admin.support.ticket.index', 'admin.support.ticket.search'])}}" href="{{route('admin.support.ticket.index')}}"><i class="lab la-jira me-3"></i> {{ translate('All Ticket')}}
                            </a>

                            <a class="{{menuActive('admin.support.ticket.running')}}" href="{{route('admin.support.ticket.running')}}"><i class="lab la-jira me-3"></i> {{ translate('Running Ticket')}}
                            @if($running_support_ticket_count > 0)
                                <span class="badge bg-danger"> {{$running_support_ticket_count}}</span>
                            @endif
                            </a>

                            <a class="{{menuActive('admin.support.ticket.answered')}}" href="{{route('admin.support.ticket.answered')}}"><i class="lab la-jira me-3"></i> {{ translate('Answered Ticket')}}</a>

                            <a class="{{menuActive('admin.support.ticket.replied')}}" href="{{route('admin.support.ticket.replied')}}"><i class="lab la-jira me-3"></i> {{ translate('Replied Ticket')}}</a>

                            <a class="{{menuActive('admin.support.ticket.closed')}}" href="{{route('admin.support.ticket.closed')}}"><i class="lab la-jira me-3"></i> {{ translate('Closed Ticket')}}</a>
                        </li>
                    </ul>
                </li>

                <li class="side_bar_list d--flex align--center">
                    <a class="ms--1 d--flex align--center {{menuActive(['admin.system.info'])}}" href="{{route('admin.system.info')}}">
                        <div>
                            <span class="me-3"><i class="fs-5 las la-tools text--light me-2"></i></span> {{ translate('Server Information')}}
                        </div>
                    </a>
                </li>

                <li class="side_bar_list d--flex align--center">
                    <a class="ms--1 d--flex align--center" href="{{route('admin.general.setting.cache.clear')}}">
                        <div>
                            <span class="me-3"><i class="fs-5 las la-atom text--light me-2"></i></span> {{ translate('Cache Clear')}}
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <br>
        <div class="text-center p-1 text-uppercase version">
            <span class="text--primary"> {{ translate('iGENSOLUTIONSLTD')}}</span>
            <span class="text--success"> {{ translate(config('requirements.core.appVersion'))}}</span>
        </div>
    </div>
</div>


