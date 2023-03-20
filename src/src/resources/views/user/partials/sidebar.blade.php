<div id="sideContent" class="side_content">
    <div class="logo_container">
        <div class="logo_name">
            <div class="logo_img">
                <img src="{{showImage(filePath()['site_logo']['path'].'/site_logo.png')}}" alt="{{ translate('Site Logo')}}">
                <div onclick="showSideBar()" class="cross">
                    <i class="lar la-times-circle fs--9 text--light"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="side_bar_menu_container">
        <div class="side_bar_menu_list">
            <ul>
                <li class="side_bar_list d--flex align--center">
                    <a class="ms--1 d--flex align--center {{menuActive('user.dashboard')}}" href="{{route('user.dashboard')}}">
                        <div>
                            <span class="me-3"><i class="fs-5 las la-home text--light me-2"></i></span>{{ translate('Dashboard')}}
                        </div>
                    </a>
                </li>
            </ul>
            <ul>
                <li class="side_bar_list d--flex align--center">
                    <a class="ms--1 d--flex align--center {{menuActive('user.plan.create')}}" href="{{route('user.plan.create')}}">
                        <div>
                            <span class="me-3"><i class="fs-5 lab la-telegram-plane text--light me-2"></i></span>{{ translate('Pricing Plan') }}
                        </div>
                    </a>
                </li>

                <li class="side_bar_list d--flex align--center">
                    <a class="ms--1 d--flex align--center {{menuActive('user.plan.subscription')}}" href="{{route('user.plan.subscription')}}">
                        <div>
                            <span class="me-3"><i class="fs-5 las la-paper-plane text--light me-2"></i></span>{{ translate('Subscriptions')}}
                        </div>
                    </a>
                </li>
            </ul>

            <h1 class="text--light m-2">{{ translate('Group & Contacts')}}</h1>
            <ul>
                <li>
                    <a class="ms--1 d--flex align--center {{sidebarMenuActive(['user.phone.book.group.index', 'user.phone.book.contact.index','user.phone.book.template.index', 'user.phone.book.sms.contact.group'])}} side_bar_twenty_list" href="javascript:void(0)"><div><span class="me-4"><i class="fs-5 las la-sms text--light"></i></span>{{ translate('Phonebook Contact')}}</div><i class="las la-angle-down icon20"></i></a>
                    <ul class="first_twenty_child {{menuActive('user.phone.book*',20)}}">
                        <li>
                            <a class="{{menuActive(['user.phone.book.group.index','user.phone.book.sms.contact.group'])}}" href="{{route('user.phone.book.group.index')}}"><i class="lab la-jira me-3"></i>{{ translate('Groups')}}</a>
                            <a class="{{menuActive('user.phone.book.contact.index')}}" href="{{route('user.phone.book.contact.index')}}"><i class="lab la-jira me-3"></i>{{ translate('Contacts')}}</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="ms--1 d--flex align--center {{sidebarMenuActive(['user.email.group.index', 'user.email.contact.index', 'user.email.contact.group'])}} side_bar_eight_list" href="javascript:void(0)"><div><span class="me-4"><i class="fs-5 las la-envelope text--light"></i></span>{{ translate('Email Address')}}</div><i class="las la-angle-down icon8"></i></a>
                    <ul class="first_eight_child {{menuActive('user.email*',8)}}">
                        <li>
                            <a class="{{menuActive(['user.email.group.index','user.email.contact.group'])}}" href="{{route('user.email.group.index')}}"><i class="lab la-jira me-3"></i>{{ translate('Groups')}}</a>
                            <a class="{{menuActive('user.email.contact.index')}}" href="{{route('user.email.contact.index')}}"><i class="lab la-jira me-3"></i>{{ translate('Contacts')}}</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <h1 class="text--light m-2">{{ translate('Messaging & Mail')}}</h1>
            <ul>
                <li>
                    <a class="ms--1 d--flex align--center {{sidebarMenuActive(['user.sms.send','user.sms.index','user.sms.pending','user.sms.schedule', 'user.sms.delivered', 'user.sms.failed', 'user.sms.search', 'user.sms.date.search', 'user.sms.processing'])}} side_bar_nine_list" href="javascript:void(0)"><div><span class="me-4"><i class="fs-5 las la-inbox text--light"></i></span>{{ translate('Manage SMS')}}</div><i class="las la-angle-down icon9"></i></a>
                    <ul class="first_nine_child {{menuActive('user.sms*',9)}}">
                        <li>
                            <a class="{{menuActive('user.sms.send')}}" href="{{route('user.sms.send')}}"><i class="lab la-jira me-3"></i>{{ translate('Send SMS')}}</a>
                            <a class="{{menuActive('user.sms.index')}}" href="{{route('user.sms.index')}}"><i class="lab la-jira me-3"></i>{{ translate('All SMS')}}</a>
                             <a class="{{menuActive('user.sms.pending')}}" href="{{route('user.sms.pending')}}"><i class="lab la-jira me-3"></i>{{ translate('Pending SMS')}}</a>
                             <a class="{{menuActive('user.sms.schedule')}}" href="{{route('user.sms.schedule')}}"><i class="lab la-jira me-3"></i>{{ translate('Schedule SMS')}}</a>
                              <a class="{{menuActive('user.sms.processing')}}" href="{{route('user.sms.processing')}}"><i class="lab la-jira me-3"></i>{{ translate('Processing SMS')}}</a>
                             <a class="{{menuActive('user.sms.delivered')}}" href="{{route('user.sms.delivered')}}"><i class="lab la-jira me-3"></i>{{ translate('Delivered SMS')}}</a>
                             <a class="{{menuActive('user.sms.failed')}}" href="{{route('user.sms.failed')}}"><i class="lab la-jira me-3"></i>{{ translate('Failed SMS')}}</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="ms--1 d--flex align--center {{sidebarMenuActive(['user.whatsapp.send','user.whatsapp.index','user.whatsapp.pending','user.whatsapp.schedule', 'user.whatsapp.delivered', 'user.whatsapp.failed', 'user.whatsapp.search', 'user.whatsapp.date.search', 'user.whatsapp.processing'])}} side_bar_twenty_three_list" href="javascript:void(0)"><div><span class="me-4"><i class="fs-5 fab fa-whatsapp text--light"></i></span>{{ translate('Manage WhatsApp')}}</div><i class="las la-angle-down icon23"></i></a>
                    <ul class="first_twenty_three_child {{menuActive('user.whatsapp*',23)}}">
                        <li>
                            <a class="{{menuActive('user.whatsapp.send')}}" href="{{route('user.whatsapp.send')}}"><i class="lab la-jira me-3"></i>{{ translate('Send Message')}}</a>
                            <a class="{{menuActive('user.whatsapp.index')}}" href="{{route('user.whatsapp.index')}}"><i class="lab la-jira me-3"></i>{{ translate('All Message')}}</a>
                             <a class="{{menuActive('user.whatsapp.pending')}}" href="{{route('user.whatsapp.pending')}}"><i class="lab la-jira me-3"></i>{{ translate('Pending Message')}}</a>
                             <a class="{{menuActive('user.whatsapp.schedule')}}" href="{{route('user.whatsapp.schedule')}}"><i class="lab la-jira me-3"></i>{{ translate('Schedule Message')}}</a>
                              <a class="{{menuActive('user.whatsapp.processing')}}" href="{{route('user.whatsapp.processing')}}"><i class="lab la-jira me-3"></i>{{ translate('Processing Message')}}</a>
                             <a class="{{menuActive('user.whatsapp.delivered')}}" href="{{route('user.whatsapp.delivered')}}"><i class="lab la-jira me-3"></i>{{ translate('Delivered Message')}}</a>
                             <a class="{{menuActive('user.whatsapp.failed')}}" href="{{route('user.whatsapp.failed')}}"><i class="lab la-jira me-3"></i>{{ translate('Failed Message')}}</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a class="ms--1 d--flex align--center {{sidebarMenuActive(['user.manage.email.send', 'user.manage.email.index', 'user.manage.email.pending','user.manage.email.schedule','user.manage.email.delivered', 'user.manage.email.failed','user.manage.email.search','user.manage.email.date.search'])}} side_bar_ten_list" href="javascript:void(0)"><div><span class="me-4"><i class="fs-5 las la-envelope-open-text text--light"></i></span>{{ translate('Manage Email')}}</div><i class="las la-angle-down icon10"></i></a>
                    <ul class="first_ten_child {{menuActive('user.manage.email*',10)}}">
                        <li>
                            <a class="{{menuActive('user.manage.email.send')}}" href="{{route('user.manage.email.send')}}"><i class="lab la-jira me-3"></i>{{ translate('Send Email')}}</a>
                            <a class="{{menuActive(['user.manage.email.index','user.manage.email.search', 'user.manage.email.date.search'])}}" href="{{route('user.manage.email.index')}}"><i class="lab la-jira me-3"></i>{{ translate('All Email')}}</a>
                             <a class="{{menuActive('user.manage.email.pending')}}" href="{{route('user.manage.email.pending')}}"><i class="lab la-jira me-3"></i>{{ translate('Pending Email')}}</a>
                             <a class="{{menuActive('user.manage.email.schedule')}}" href="{{route('user.manage.email.schedule')}}"><i class="lab la-jira me-3"></i>{{ translate('Schedule Email')}}</a>
                             <a class="{{menuActive('user.manage.email.delivered')}}" href="{{route('user.manage.email.delivered')}}"><i class="lab la-jira me-3"></i>{{ translate('Delivered Email')}}</a>
                             <a class="{{menuActive('user.manage.email.failed')}}" href="{{route('user.manage.email.failed')}}"><i class="lab la-jira me-3"></i>{{ translate('Failed Email')}}</a>
                        </li>
                    </ul>
                </li>

                <li class="side_bar_list d--flex align--center">
                    <a class="ms--1 d--flex align--center {{menuActive('user.template.index')}}" href="{{route('user.template.index')}}">
                        <div>
                            <span class="me-3"><i class="las la-braille fs-5 text--light me-2"></i></span>{{ translate('Messaging Template')}}
                        </div>
                    </a>
                </li>
            </ul>

            <h1 class="text--light m-2">{{ translate('TRANSACTIONAL REPORT')}}</h1>
            <ul>
                <li class="side_bar_list d--flex align--center">
                    <a class="ms--1 d--flex align--center {{menuActive(['user.transaction.history', 'user.transaction.search'])}}" href="{{route('user.transaction.history')}}">
                        <div>
                            <span class="me-3"><i class="fs-5 las la-credit-card text--light me-2"></i></span>{{ translate('Transaction Log')}}
                        </div>
                    </a>
                </li>

                <li class="side_bar_list d--flex align--center">
                    <a class="ms--1 d--flex align--center {{menuActive(['user.credit.history', 'user.credit.search'])}}" href="{{route('user.credit.history')}}">
                        <div>
                            <span class="me-3"><i class="las la-bars fs-5 text--light me-2"></i></span>{{ translate('SMS Credit Log')}}
                        </div>
                    </a>
                </li>

                <li class="side_bar_list d--flex align--center">
                    <a class="ms--1 d--flex align--center {{menuActive(['user.credit.email.history', 'user.credit.email.search'])}}" href="{{route('user.credit.email.history')}}">
                        <div>
                            <span class="me-3"><i class="las la-tasks fs-5 text--light me-2"></i></span>{{ translate('Email Credit Log')}}
                        </div>
                    </a>
                </li>
            </ul>
            <h1 class="text--light m-2">{{ translate('Support')}}</h1>
            <ul>
                <li class="side_bar_list d--flex align--center">
                    <a class="ms--1 d--flex align--center {{menuActive(['user.ticket.index', 'user.ticket.detail', 'user.ticket.create'])}}" href="{{route('user.ticket.index')}}">
                        <div>
                            <span class="me-3"><i class="las la-ticket-alt fs-5 text--light me-2"></i></span>{{ translate('Support Ticket')}}
                        </div>
                    </a>
                </li>
            </ul>
        </div>
        <br>
        <div class="text-center p-1 text-uppercase version">
            <span class="text--primary">{{ translate('iGENSOLUTIONSLTD')}}</span>
            <span class="text--success">{{ translate(config('requirements.core.appVersion'))}}</span>
        </div>
    </div>
</div>
