<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>{$site_title}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link href="{$THEME}css/bootstrap.min.css" rel="stylesheet" media="screen"/>
        <link href="{$THEME}css/bootstrap-theme.min.css" rel="stylesheet" media="screen"/>
        <link href="{$THEME}css/style.css" rel="stylesheet" media="screen"/>
        <link href="{$THEME}css/offcanvas.css" rel="stylesheet" media="screen"/>

        <!--[if lt IE 9]>
            <script src="{$THEME}js/html5shiv.js"></script>
            <script src="{$THEME}js/respond.min.js"></script>
        <![endif]-->
        <link rel="icon" type="image/vnd.microsoft.icon" href="favicon.ico" />
        <link rel="SHORTCUT ICON" href="favicon.ico" />

        <link media="screen" rel="stylesheet" href="{$THEME}js/highlight/styles/default.css"/>
        <script type="text/javascript" src="{$THEME}js/highlight/highlight.pack.js"></script>

        {literal}
            <script>hljs.initHighlightingOnLoad();</script>
        {/literal}

        <script type="text/javascript" src="{$THEME}js/tinymce/tinymce.js"></script>

        <link href="{$THEME}css/docs_style.css" rel="stylesheet" media="screen"/>

        {literal}
            <script type="text/javascript">
                tinymce.init({
                    selector: "div.description",
                    inline: true,
                    plugins: [
                        "advlist autolink lists link image charmap print preview anchor",
                        "searchreplace visualblocks code fullscreen",
                        "insertdatetime media table contextmenu paste spellchecker responsivefilemanager"
                    ],
                    language: 'ru',
                    spellchecker_language: "ru",
                    spellchecker_rpc_url: "http://speller.yandex.net/services/tinyspell",
                    toolbar1: "undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | save_button | highlightcode | spellchecker",
                    image_advtab: true, 
                    external_filemanager_path: "/templates/documentation/js/tinymce/plugins/responsivefilemanager/", 
                    filemanager_title: "Responsive Filemanager", 
                    external_plugins: {"filemanager": "/templates/documentation/js/tinymce/plugins/responsivefilemanager/plugin.min.js"},
                    setup: function(editor) {
                        editor.addButton('save_button', {
                            text: 'Сохранить',
                            icon: 'save',
                            onclick: function() {
                                editor.insertContent('Main button');
                            }
                        });
                        editor.addButton('highlightcode', {
                            text: 'Код',
                            icon: 'code',
                            onclick: function() {
                                var text = editor.selection.getContent({'format': 'text'});
                                if (text && text.length > 0) {
                                    editor.execCommand('mceInsertContent', false, '<pre><code class="php">' + text + '</code></pre>');
                                }
                            }
                        });
                    }

                });

                tinymce.init({
                    selector: "h1",
                    inline: true,
                    toolbar: "undo redo | save_button | spellchecker",
                    plugins: ["spellchecker"],
                    spellchecker_language: "ru",
                    spellchecker_rpc_url: "http://speller.yandex.net/services/tinyspell",
                    menubar: false,
                    setup: function(editor) {
                        editor.addButton('save_button', {
                            text: 'Сохранить',
                            icon: 'save',
                            onclick: function() {
                                editor.insertContent('Main button');
                            }
                        });
                    }
                });
            </script>
        {/literal}

    </head>
    <body>
        <div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
            <div class="container">
                <div class="navbar-header">

                    <button type="button" class="pull-left visible-xs navbar-toggle" data-toggle="offcanvas">
                        <span class="glyphicon glyphicon-th-list white"></span>
                    </button>

                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a class="navbar-brand" href="/">
                        {lang('ImageCMS Documentation','documentation')}
                    </a>

                </div>

                <div class="collapse navbar-collapse">
                    {load_menu('top_menu')}
                    {if !$CI->dx_auth->is_logged_in()}
                        <form class="navbar-form navbar-right" method="post" id="login_form" action="/auth/login">
                            <div class="form-group">
                                <input type="text" name="email" placeholder="Email" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" placeholder="Password" class="form-control"/>
                            </div>
                            <button type="submit" class="btn btn-success">
                                <span class="glyphicon glyphicon-log-in"></span>
                                {lang('Sign in','documentation')}
                            </button>
                            {form_csrf()}
                        </form>
                    {else:}
                        <div class="pull-right">
                            {if $CI->dx_auth->is_admin()}
                                <a href="/documentation/create_new_page" type="button" class="btn btn-success navbar-btn ">
                                    <span class="glyphicon glyphicon-new-window"></span>
                                    {lang('Create','documentation')}
                                </a>
                                {if $CI->core->core_data['data_type'] == 'page'}
                                <a href="/documentation/edit_page/{echo $CI->core->core_data['id']}" type="button" class="btn btn-success navbar-btn ">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                    {lang('Edit','documentation')}
                                </a>
                                {/if}
                            {/if}
                            <a href="/auth/logout" type="button" class="btn btn-success navbar-btn ">
                                <span class="glyphicon glyphicon-log-out"></span>
                                {lang('Exit','documentation')}
                            </a>
                        </div>
                    {/if}
                </div><!-- /.nav-collapse -->
            </div><!-- /.container -->
        </div>
        <div class="container">
            <div class="row row-offcanvas row-offcanvas-left">
                <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
                    <div class="tree_menu">
                        {load_menu('left_menu')}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-9">
                    <p class="pull-left visible-xs">
                        <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Toggle nav</button>
                    </p>
                    <div class="jumbotron">
                        <h1>Hello, world!</h1>
                        <p>This is an example to show the potential of an offcanvas layout pattern in Bootstrap. Try some responsive-range viewport sizes to see it in action.</p>
                    </div>
                    <div class="row">
                        {$content}
                    </div>
                </div>
            </div>
            <hr/>
            <footer>
                <p>© Company 2013</p>
            </footer>
        </div>
        <script type="text/javascript" src="{$THEME}js/jquery.min.js"></script>
        <script type="text/javascript" src="{$THEME}js/bootstrap.min.js"></script>
        <script type="text/javascript" src="{$THEME}js/offcanvas.js"></script>
    </body>
</html>