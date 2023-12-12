/*
 *  Document   : op_auth_signup.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Sign Up Page
 */

// Form Validation, for more examples you can check out https://github.com/jzaefferer/jquery-validation
class pageAuthSignUp {
  /*
   * Init Sign Up Form Validation
   *
   */
  static initValidationSignUp() {
    // Load default options for jQuery Validation plugin
    Codebase.helpers('jq-validation');

    // Init Form Validation
    jQuery('.js-validation-signup').validate({
      rules: {
        'signup-username': {
          required: true,
          minlength: 3
        },
        'signup-email': {
          required: true,
          emailWithDot: true
        },
        'signup-password': {
          required: true,
          minlength: 5
        },
        'signup-password-confirm': {
          required: true,
          equalTo: '#signup-password'
        },
        'signup-terms': {
          required: true
        }
      },
      messages: {
        'signup-username': {
          required: 'Please enter a username',
          minlength: 'Your username must consist of at least 3 characters'
        },
        'signup-email': 'Please enter a valid email address',
        'signup-password': {
          required: 'Please provide a password',
          minlength: 'Your password must be at least 5 characters long'
        },
        'signup-password-confirm': {
          required: 'Please provide a password',
          minlength: 'Your password must be at least 5 characters long',
          equalTo: 'Please enter the same password as above'
        },
        'signup-terms': 'You must agree to the service terms!'
      }
    });
  }

  /*
   * Init functionality
   *
   */
  static init() {
    this.initValidationSignUp();
  }
}

// Initialize when page loads
Codebase.onLoad(pageAuthSignUp.init());
