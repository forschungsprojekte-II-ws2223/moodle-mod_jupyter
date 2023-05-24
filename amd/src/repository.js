import { call as fetchMany } from "core/ajax";

export const submitNotebook = (user, contextid) =>
  fetchMany([
    {
      methodname: "mod_jupyter_submit_notebook",
      args: {
        user,
        contextid,
      },
    },
  ])[0];

export const resetNotebook = (user, contextid, courseid, instanceid) =>
  fetchMany([
    {
      methodname: "mod_jupyter_reset_notebook",
      args: {
        user,
        contextid,
        courseid,
        instanceid,
      },
    },
  ])[0];
