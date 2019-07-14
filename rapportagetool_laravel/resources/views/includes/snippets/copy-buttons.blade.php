<div class="">
    <a title="Copy '{{$obj}}' to clipboard"
       id = "btnCopyCC"
       href="#"
       class="btn btn-sm btn-outline-secondary btnClipboard"
       data-clipboard-return-id-target="btnCopyCC"
       data-clipboard-text = "{{$obj}}">
        Clipboard
    </a>
    <a title="Copy '[cc]{{$obj}}[/cc]' to clipboard"
       id = "btnCopyCCbb"
       href="#"
       class="btn btn-sm btn-outline-secondary btnClipboard"
       data-clipboard-return-id-target="btnCopyCCbb"
       data-clipboard-text = "[cc]{{$obj}}[/cc]">
        Clipboard as BB
    </a>
    <a title="Copy 'http://localhost/casefiles/cc/{{$obj}}' to clipboard"
       id = "btnCopyCClink"
       href="#"
       class="btn btn-sm btn-outline-secondary btnClipboard"
       data-clipboard-return-id-target="btnCopyCClink"
       data-clipboard-text = "http://localhost/casefiles/cc/{{$obj}}">
        Clipboard as URL
    </a>
    <a title="Copy 'http://localhost/casefiles/cc/{{$obj}}' to clipboard"
       id = "btnCopyCClink"
       href="#"
       class="btn btn-sm btn-outline-secondary btnClipboard"
       data-clipboard-return-id-target="btnCopyCClink"
       data-clipboard-text = "http://localhost/casefiles/cc/{{$obj}}">
        Send in Message
    </a>
</div>