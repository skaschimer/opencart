import { WebComponent } from '../library/webcomponent.js';
import { loader } from '../index.js';

const language = loader.language('default');

class XCheckbox extends WebComponent {
    static observed = ['checked'];
    option = [];

    async connected() {
        this.option = this.querySelectorAll('option');
    };

    render() {
        let html = '<div id="' + option.getAttribute('input-id') + '" class="form-control" style="height: 150px; overflow: auto;">';

        for (let option of this.option) {
            html += '<div class="form-check">';
            html += '   <input type="checkbox"';

            if (option.hasAttribute('name')) {
                html += ' name="' + option.getAttribute('name') + '"';
            }

            if (option.hasAttribute('value')) {
                html += ' value="' + option.getAttribute('value') + '"';
            }

            if (option.hasAttribute('input-id')) {
                html += ' id="' + option.getAttribute('input-id') + '"';
            }

            html += 'class="form-check-input"';

            if (option.hasAttribute('target')) {
                html += ' data-on="change:onChange" data-target="' + option.getAttribute('target') + '"';
            }

            if (option.hasAttribute('checked')) {
                html += ' checked';
            }

            html += '/>';

            html += '   <label for="' + option.getAttribute('input-id') + '" class="form-check-label">' + option.innerHTML + '</label>';
            html += '</div>';
        }

        html += '</div>';

        return html;
    }

    onChange(e) {
        //$('input[name*=\'config_country_list\']').prop('checked', $(this).prop('checked'));

        console.log('onChange', e.target.checked);

        let target = document.getElementById(e.target.getAttribute('data-target'));

        let options = target.querySelectorAll('option');

        for (let option of options) {

        console.log('onChange', target);

        e.target.checked ? 1 : 0;
    }
}

customElements.define('x-checkbox', XCheckbox);