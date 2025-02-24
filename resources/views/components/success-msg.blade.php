<link rel="stylesheet" href="{{ asset("/css/component.css") }}">
<div id="success-msg">
    <div id="message" style=" background-color: {{ $color }};">
        {{ $message }}
        <p onclick="dismissMessagee()" style="cursor: pointer; padding-left: 5px; padding-right: 5px; margin: 0; color: black;">X</p>
    </div>
</div>

<script>
function dismissMessagee() {
    document.getElementById("success-msg").style.display = "none";
}
</script>