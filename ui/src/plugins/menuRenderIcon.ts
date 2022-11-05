import * as IconFluent from './menuIconConfig';
const renderIconComponents = (_filename: string) => {
    return IconFluent[_filename as keyof typeof IconFluent]
}

export default renderIconComponents;

