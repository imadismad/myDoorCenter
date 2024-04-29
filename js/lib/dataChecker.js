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

/**
 * Check if a credit card number is a Visa card
 * @param {string} cardNumber The card number to check
 * @returns If the credit card is a Visa card
 */
function checkVisa(cardNumber) {
    const regexCheck = /^4\d{3}-?\d{4}-?\d{4}-?\d{4}$/;
    return regexCheck.test(cardNumber);
}

/**
 * Check if a credit card number is a MasterCard
 * @param {string} cardNumber The card number to check
 * @returns If the credit card is a MasterCard
 */
function checkMasterCard(cardNumber) {
    const regexCheck = /^5[1-5]\d{2}-?\d{4}-?\d{4}-?\d{4}$/;
    return regexCheck.test(cardNumber);
}

export { checkVisa, checkMasterCard, checkMail, checkPhone };