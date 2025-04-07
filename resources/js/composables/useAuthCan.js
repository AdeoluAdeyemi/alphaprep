import { usePage } from '@inertiajs/vue3'

export default function useAuthCan() {
    const auth = usePage().props.auth

    const can = (permission) => {

        // use this to determine whether b was passed or not
    //     if (arguments.length == 0) {
    //         // permission was not passed
    //         if ((auth && auth.isSuperAdminUser) || (auth && auth.isAdminUser) ) {
    //             return true
    //         }
    //     }
    //     else {

    //     }
    // }
        if ((auth && auth.isSuperAdminUser) || (auth && auth.isAdminUser) ) {
            return true
        }

        return auth && auth.permissions.includes(permission)
    }

    return { can }
}


