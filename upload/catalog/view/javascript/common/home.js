import { Controller } from '../component.js';
import { loader } from '../index.js';

export default class extends Controller {
    async render() {

        return loader.template('common/home', { ...data, ...language });
    }
}