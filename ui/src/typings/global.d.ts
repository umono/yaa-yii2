

import { DataTableBtn } from '@/mixins/common';
import Request from '@/utils/http/request'
import { Store } from 'vuex';

declare module '@vue/runtime-core' {
    interface State {
        theme: any,
        auth: any,
        mestore: any,
    }

    export interface ComponentCustomProperties {
        $store:  Store<State>,
        $http: Request,

        openModal:any,
        _handleBtn:DataTableBtn[],
        $can:any
    }


    export interface ComponentConstruct {
        $store: Store<State>,
        $http: Request,
    }
}
