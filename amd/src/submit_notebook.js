import { submitNotebook } from './repository';
import { exception as displayException } from 'core/notification';
import Templates from 'core/templates';
import { get_string as getString } from 'core/str';

const context = {
    message: '',
    closebutton: 1,
    announce: 1
};

const Selectors = {
    elements: {
        submitResponse: '[data-element="mod_jupyter/submit-response"]'
    },
    actions: {
        submitButton: '[data-action="mod_jupyter/submit-notebook_button"]',
    },
};

export const init = async ({ user, courseid, instanceid, filename, token }) => {
    getString('submitsuccessnotification', 'mod_jupyter')
        .then(str => {
            context.message = str;
        })
        .catch();

    document.addEventListener('click', e => {
        if (e.target.closest(Selectors.actions.submitButton)) {
            callSubmitNotebook(user, courseid, instanceid, filename, token);

            // This will call the function to load and render our template.
            Templates.renderForPromise('core/notification_info', context)

                // It returns a promise that needs to be resoved.
                .then(({ html, js }) => {
                    // Here eventually I have my compiled template, and any javascript that it generated.
                    // The templates object has append, prepend and replace functions.
                    Templates.appendNodeContents(Selectors.elements.submitResponse, html, js);
                })
                // Deal with this exception (Using core/notify exception function is recommended).
                .catch((error) => displayException(error));
        }
    });
};

const callSubmitNotebook = async (user, courseid, instanceid, filename, token) => {
    const response = await submitNotebook(user, courseid, instanceid, filename, token);
    window.console.log(response);
    //return response;
};
