<div class="sidebar" data="blue">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text logo-mini">{{ __('MM') }}</a>
            <a href="#" class="simple-text logo-normal">{{ __('Management') }}</a>
        </div>
        <ul class="nav">
            <li @if ($pageSlug == 'dashboard') class="active " @endif>
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            
            <li>
                <a data-toggle="collapse" href="#pdf_templates_menu" aria-expanded="true">
                    <i class="tim-icons icon-cloud-upload-94" ></i>
                    <span class="nav-link-text" >{{ __('PDF Templates') }}</span>
                    <b class="caret mt-1"></b>
                </a>
                
                <div class="collapse @if($activePage=='pdfsection') show @endif" id="pdf_templates_menu">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'listpdf') class="active " @endif>
                            <a href="{{ route('pages.templatelist')  }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Templates') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'addpdftemplate') class="active " @endif>
                            <a href="{{ route('pages.addtemplate')  }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ __('Add Template') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a data-toggle="collapse" href="#email_templates_menu" aria-expanded="true">
                    <i class="tim-icons icon-email-85" ></i>
                    <span class="nav-link-text" >{{ __('Email Templates') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse @if($activePage=='emailsection') show @endif" id="email_templates_menu">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'list_email') class="active " @endif>
                            <a href="{{ route('pages.viewemailtemplate')  }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Templates') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'add_email') class="active " @endif>
                            <a href="{{ route('pages.addemailtemplate')  }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ __('Add Template') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'fixemails') class="active " @endif>
                            <a href="{{ route('pages.viewfixemailtemplate')  }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ __('Fix Emails') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a data-toggle="collapse" href="#invoice_menu" @if($activePage=='templatelist') aria-expanded="true" @endif>
                <i class="tim-icons icon-single-copy-04"></i>
                    <span class="nav-link-text" >{{ __('Contracts') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse @if($activePage=='templatelist') show @endif" id="invoice_menu">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'listtemplate') class="active " @endif>
                            <a href="{{ route('pages.invoicelist')  }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('All Contracts') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'addinvoicePages') class="active " @endif>
                            <a href="{{ route('pages.addinvoice')  }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ __('Add New') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
           
            <li>
                <a data-toggle="collapse" href="#usermenuex" aria-expanded="true">
                    <i class="tim-icons icon-settings" ></i>
                    <span class="nav-link-text" >{{ __('Users') }}</span>
                    <b class="caret mt-1"></b>
                </a>
                
                <div class="collapse @if($activePage=='userprofile') show @endif" id="usermenuex">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'profile') class="active " @endif>
                            <a href="{{ route('profile.edit')  }}?user_id={{Auth::id()}}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ __('My Profile') }}</p>
                            </a>
                        </li>
                        @if(Auth::id()==1)
                        <li @if ($pageSlug == 'userlist') class="active " @endif>
                            <a href="{{ route('user.userlist')  }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ __('User Profile') }}</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
