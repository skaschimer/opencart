import { Controller } from '../component.js';
import { loader } from '../index.js';

// Language
const language = await loader.language('account/return');

export default class extends Controller {
   render() {
       return loader.template('account/return', { ...language });
    }

    onSubmit(e) {
        e.preventDefault();

    }
}