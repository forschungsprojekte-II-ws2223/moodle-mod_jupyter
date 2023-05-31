import { submitNotebook } from "./repository";
import { exception as displayException } from "core/notification";
import Templates from "core/templates";

const context = {
  message: "",
  closebutton: 1,
  announce: 1,
  points: []
};

const Selectors = {
  elements: {
    submitResponseBody: '[data-element="mod_jupyter/body-placeholder"]',
  },
  actions: {
    submitButton: '[data-action="mod_jupyter/submit-notebook_button"]',
    resetModal: '[data-action="mod_jupyter/reset-modal_button"]',
  },
};


/**
 * Add event listeners to Selectors.
 * @param {*} param0
 */
export const init = async ({ user, courseid, instanceid, filename, token }) => {
  document.addEventListener("click", (e) => {
    if (e.target.closest(Selectors.actions.submitButton)) {
      resetModalTable();
      callSubmitNotebook(user, courseid, instanceid, filename, token);
    }
  });

  document.addEventListener("click", (e) => {
    if (e.target.closest(Selectors.actions.resetModal)) {
      resetModalTable();
    }
  });
};


/**
 * Call external service from repository to submit notebook to grading service and display graded response.
 *
 * @param {string} user
 * @param {int} courseid
 * @param {int} instanceid
 * @param {string} filename
 * @param {string} token
 */
const callSubmitNotebook = async (
  user,
  courseid,
  instanceid,
  filename,
  token
) => {
  const response = await submitNotebook(
    user,
    courseid,
    instanceid,
    filename,
    token
  );
  context.points = response;
  renderModalTable();
};

/**
 * Render table inside the submit modal to show submit response.
 */
const renderModalTable = (
) => {
  Templates.renderForPromise("mod_jupyter/submit_response_modal_table", context)
    // It returns a promise that needs to be resoved.
    .then(({ html, js }) => {
      // Here eventually I have my compiled template, and any javascript that it generated.
      // The templates object has append, prepend and replace functions.
      Templates.replaceNodeContents(
        Selectors.elements.submitResponseBody,
        html,
        js
      );
    })
    // Deal with this exception (Using core/notify exception function is recommended).
    .catch((error) => displayException(error));
};

/**
 * Replace table with loading template for reset.
 */
const resetModalTable = async (
) => {
  Templates.renderForPromise("mod_jupyter/loading", context)
    // It returns a promise that needs to be resoved.
    .then(({ html, js }) => {
      // Here eventually I have my compiled template, and any javascript that it generated.
      // The templates object has append, prepend and replace functions.
      Templates.replaceNodeContents(
        Selectors.elements.submitResponseBody,
        html,
        js
      );
    })
    // Deal with this exception (Using core/notify exception function is recommended).
    .catch((error) => displayException(error));
};
