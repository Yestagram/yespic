<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>OnePaper</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0">
    <script type="text/javascript" src="//unpkg.com/wangeditor@4.7.0/dist/wangEditor.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
            padding: 0;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }

        .toolbar {
            border: 1px solid #ccc;
        }

        .text {
            border: 1px solid #ccc;
            min-height: 400px;
            height: calc(100vh - 240px);
        }

        .input-text {
            border: deepskyblue 1px solid;
            padding: 8px 4px;
            text-indent: 6px;
            display: block;
            width: 100%;
            box-sizing: border-box;
        }

        .input-text:focus,
        .input-text:active {
            border: yellowgreen 1px solid;
            outline: none;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 2px;
            border: deepskyblue 1px solid;
            background: linear-gradient(deepskyblue, dodgerblue);
            color: white;
            outline: none;
        }

        .btn:focus {
            border: dodgerblue 1px solid;
        }

        .btn:active {
            border: dodgerblue 1px solid;
            background: linear-gradient(dodgerblue, deepskyblue);
        }

        .result {
            display: none;
            border: khaki 1px solid;
            background-color: #fff9cb;
            padding: 10px;
        }
    </style>
</head>
<body>
<div id="toolbar" class="toolbar">
</div>
<div style="padding: 5px 0; color: #ccc">
    <label for="txt_title"><?= $_LANG['title'] ?></label><input id="txt_title" type="text" class="input-text"/>
</div>
<div id="editor" class="text">
</div>
<div style="margin-top: 12px;">
    <button id="btn_publish" class="btn"><?= $_LANG['publish'] ?></button>
</div>
<p class="result" id="txt_result"></p>
<script type="text/css" id="css">
    table {
        border-top: 1px solid #ccc;
        border-left: 1px solid #ccc;
    }

    table td,
    table th {
        border-bottom: 1px solid #ccc;
        border-right: 1px solid #ccc;
        padding: 3px 5px;
    }

    table th {
        border-bottom: 2px solid #ccc;
        text-align: center;
    }

    blockquote {
        display: block;
        border-left: 8px solid #d0e5f2;
        padding: 5px 10px;
        margin: 10px 0;
        line-height: 1.4;
        font-size: 100%;
        background-color: #f1f1f1;
    }

    code {
        display: inline-block;
        *display: inline;
        *zoom: 1;
        background-color: #f1f1f1;
        border-radius: 3px;
        padding: 3px 5px;
        margin: 0 3px;
    }

    pre code {
        display: block;
    }

    ul, ol {
        margin: 10px 0 10px 20px;
    }
</script>
<script type="text/javascript">
    (function () {
        const URL = `${location.protocol}//${location.host}`;
        let editor = new wangEditor('#toolbar', '#editor');
        let btnPublish = document.getElementById('btn_publish');
        let cssTag = document.getElementById('css');
        let txtTitle = document.getElementById('txt_title');
        let txt_result = document.getElementById('txt_result');

        editor.config.menus = [
            'image',
            'head',
            'bold',
            'fontSize',
            'fontName',
            'italic',
            'underline',
            'strikeThrough',
            'foreColor',
            'backColor',
            'link',
            'list',
            'justify',
            'quote',
            'table',
            'video',
            'code',
            'undo',
            'redo',
        ];

        editor.config.customUploadImg = function (files, insert) {
            let data = new FormData();
            data.append('image', files[0]);
            fetch("/ipfs/upload", {method: 'post', mode: 'cors', body: data,})
                .then(res => res.json()).then(res => {
                insert(res.url);
            })
        };
        editor.create();

        btnPublish.addEventListener('click', _ => {
            let data = new FormData();
            let content = editor.txt.html();
            let html = `<html lang="zh"><head><meta charset="utf-8"><title>${txtTitle.value || '无标题'}</title><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0"><style>${cssTag.innerText}</style></head><body>${content}</body></html>`;
            data.append('content', html);
            fetch("/ipfs/write", {method: 'post', mode: 'cors', body: data,})
                .then(res => res.json()).then(res => {
                txt_result.innerHTML = `<a href="${res.url}" target="_blank">${URL + res.url}</a>`;
                txt_result.style.display = "block";
            })
        })
    })();
</script>
</body>
</html>