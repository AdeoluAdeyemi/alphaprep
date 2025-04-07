export function useCurrency() {

    const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

    let getLocale = Intl.DateTimeFormat().resolvedOptions().locale;

    let currency = '';
    // Ghana, Kenya, Uganda, Zambia, Rwanda, Tanzania, Francophone, M-Pesa.
    switch(getLocale){
        case 'en-NG':
            currency = 'NGN'
            break
        case 'en-GB':
            currency = 'GBP'
            break
        case 'en-US':
            currency = 'USD'
            break
        default:
            currency = 'USD'
    }

    if (timezone === 'Africa/Lagos'){
        currency = 'NGN'
        getLocale = 'en-NG'
    }
    // currency = 'NGN'
    // getLocale = 'en-NG'

    //return [timezone, getLocale]
    return {
        'timezone': timezone,
        'locale': getLocale,
        'currency': currency,
    }

}

// export function useCurrency() {
//     return { getCurrency };
// }
