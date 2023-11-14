/*
 *  Document   : op_auth_lock.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Lock Page
 */

// Form Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
class pageAuthLock {
  /*
   * Init Lock Form Validation
   *
   */
  static initValidationLock() {
    // Load default options for jQuery Validation plugin
    Codebase.helpers('jq-validation');

    // Init Form Validation
    jQuery('.js-validation-lock').validate({
      rules: {
        'lock-password': {
          required: true,
          minlength: 3
        }
      },
      messages: {
        'lock-password': {
          required: 'Please enter your valid password'
        }
      }
    });
  }

  /*
   * Init functionality
   *
   */
  static init() {
    this.initValidationLock();
  }
}

// Initialize when page loads
Codebase.onLoad(pageAuthLock.init());
