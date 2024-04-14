/**
 * This function like throttle is use to reduce the call to a function.
 * But unlike throttle, the callback is call after the timeout and not befor.
 * The timeout is reset for each new call.
 */
const limite = (func, time) => {
    let timeoutId = undefined;
    return (...args) => {
        if (timeoutId !== undefined) {
            clearTimeout(timeoutId);
        }

        timeoutId = setTimeout(() => {
            timeoutId = undefined;
            func(...args);
        }, time);
    }
}

export default limite;