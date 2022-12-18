import { defineComponent, reactive } from "vue";

type SizeType =  'tiny' | 'small' | 'medium' | 'large';
type BtnTypeStr = 'default' | 'tertiary' | 'primary' | 'info' | 'success' | 'warning' | 'error';

interface BtnType {
  size?: SizeType | string,
  emitFunction: string,
  text: string | Function | any,
  type?:BtnTypeStr| string
}

export interface DataTableBtn {
  [x: string]: any;
  title: string,
  key: string,
  width?: number,
  fixed?: 'right' | 'left',
  NButtons: BtnType[]
}


export default defineComponent({

  data() {
    return {
      _handleBtn: reactive([{
        title: '操作',
        key: 'tags',
        width: 200,
        fixed: 'right',
        NButtons: [{
          size: 'small',
          emitFunction: "view",
          text: "查看",
        },
        {
          size: 'small',
          type: 'info',
          emitFunction: "edit",
          text: "编辑"
        },
        ],
      } as DataTableBtn]),
    }
  },
  methods: {
    // 用于直接调用子组件里面的 show 方法传递一个参数
    openModal(param: any = null, refsHome: any = null) {
      if (!refsHome) {
        return window.$message.warning("请在使用openModal方法时, 填写ref名称。")
      }

      const refModal: any = this.$refs[refsHome];

      if (!refModal) {
        return window.$message.warning("请确保ref名称组件存在。")
      }
      refModal.show(param);
    },
  }
})