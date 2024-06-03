
<div id='errorToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-delay='3000' style='position: fixed; bottom: 0; right: 0; width: 300px;'>
<div class='toast-header bg-danger text-white'>
    <strong class='mr-auto'>Error</strong>
    <button type='button' class='ml-2 mb-1 close' data-dismiss='toast' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
    </button>
</div>
<div class='toast-body'>
    این یوزرنیم و پسورد قبلا به ثبت رسیده! !
</div>
</div>
<script>
$(document).ready(function(){
    $('#errorToast').toast('show');
    setTimeout(function(){
        $('#errorToast').toast('hide');
    }, 3000);
});
</script>