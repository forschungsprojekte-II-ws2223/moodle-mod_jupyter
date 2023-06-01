import { resetNotebook } from "./repository";

const Selectors = {
  actions: {
    resetButton: '[data-action="mod_jupyter/reset-notebook_button"]',
  },
};

export const init = async ({ user, contextid, courseid, instanceid }) => {
  document.addEventListener("click", (e) => {
    if (e.target.closest(Selectors.actions.resetButton)) {
      callResetNotebook(user, contextid, courseid, instanceid);
      document.getElementById("iframe").src += ""; //This is only for github supplied notebooks.
    }
  });
};

const callResetNotebook = async (user, contextid, courseid, instanceid) => {
  const response = await resetNotebook(user, contextid, courseid, instanceid);
  window.console.log(response);
};
