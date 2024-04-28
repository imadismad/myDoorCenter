import "./libphonenumber-min.js";

/**
 * Check if a mail is valide
 * @param {string} mail The mail to check
 * @returns {boolean} True if the mail is valide
 */
function checkMail(mail) {
    const regexCheck = new RegExp("^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/");
    return regexCheck.test(mail);
}

/**
 * Check if a phone number  is valide
 * @param {string} phone The phone number to check
 * @returns {boolean} True if the phone number is valide
 */
function checkPhone(phone) {
    return libphonenumber.isValidPhoneNumber(phone, "FR");
}

export { checkMail, checkPhone };