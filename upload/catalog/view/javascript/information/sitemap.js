import { Controller } from '../component.js';
import { loader } from '../index.js';

// Language
const language = await loader.language('common/language');

export default class extends Controller {
    render() {



        return loader.template('information/sitemap', language);
    }
}