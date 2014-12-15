/**
 * Create warning for crappy browsers
 */

// Only display if user hasn't already dismissed thw warning
if ('ignore' != $.cookie('crappy.browser')) {
  $('body').append('<div class="modal fade" id="browseHappyModal" tabindex="-1" role="dialog" aria-labelledby="browseHappyModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><h4 class="modal-title" id="browseHappyModalLabel"><span class="glyphicon glyphicon-warning-sign"></span> You are using an outdated browser</h4></div><div class="modal-body"><p>Please <a href="http://browsehappy.com/" target="_blank">upgrade your browser</a> to improve your experience.</p></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div></div>');
  $('#browseHappyModal').modal();
}

// When the warning is dismissed, snooze for 1 month
$('#browseHappyModal').on('hidden.bs.modal', function () {
  $.cookie('crappy.browser', 'ignore', {
    expires: 31,
    path: '/'
  });
});
