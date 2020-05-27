var $ = jQuery.noConflict()
$(document).ready(function () {
  $('.tutorial_youtube_id_error_message').hide()
  /////////////////// Youtube ID ///////////////////////////
  $('#tutorial_youtube_id').on('change keyup paste', function () {
    let tutorialYoutubeId = $.trim($('#tutorial_youtube_id').val())

    tutorialYoutubeId === ''
      ? $('.tutorial_youtube_id_error_message').show()
      : $('.tutorial_youtube_id_error_message').hide()
  })
})
