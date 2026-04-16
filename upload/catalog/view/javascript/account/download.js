import { Controller } from '../component.js';
import { loader } from '../index.js';

const language = loader.language('account/download');

export default class extends Controller {
    render() {
        let data = {};

        data.downloads = {};

        return this.load.template('account/download', { ...data, ...language });
    }
}