(function($) {
  $(document).ready(function() {
    //Date expiration
    if($('#mepr_bp_enabled').is(":checked")) {
      $('#mepr_bp_options_area').show();
    } else {
      $('#mepr_bp_options_area').hide();
    }
    $('#mepr_bp_enabled').click(function() {
      $('#mepr_bp_options_area').slideToggle('fast');
    });
    //Members area
    if($('#mepr_bp_protect_bp_section').is(":checked")) {
      $('#mepr_bp_protect_members_section').show();
      $('#mepr_bp_allow_other_profiles_section').show();
    } else {
      $('#mepr_bp_protect_members_section').hide();
      $('#mepr_bp_allow_other_profiles_section').hide();
    }
    $('#mepr_bp_protect_bp_section').click(function() {
      $('#mepr_bp_protect_members_section').slideToggle('fast');
      $('#mepr_bp_allow_other_profiles_section').slideToggle('fast');
    });
  });
})(jQuery);
