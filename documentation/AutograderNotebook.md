# Autograder notebook Dokumentation / Autograder notebook Documentation

## Deutsch

## English

Notebooks must have the following structure

```shell
# ASSIGNMENT CONFIG

WRITE HERE YOUR ASSIGNMENT CONFIGURATIONS

# BEGIN QUESTION

WRITE HERE YOUR QUESTION/TASK

# BEGIN SOLUTION

WRITE HERE YOUR SOLUTION

# END SOLUTION

# BEGIN TEST

WRITE HERE YOUR TESTS

# END TEST

# END QUESTION
```

The autograder works by writing tests. Start the notebook with `# ASSIGNMENT CONFIG` so the autograder will follow the configuration. Options of the configuration can be found below.

```shell
name: null                     # a name for the assignment (to validate that students submit to the correct autograder)
init_cell: true                # whether to include an Otter initialization cell in the output notebooks
check_all_cell: false          # whether to include an Otter check-all cell in the output notebooks
export_cell:                   # whether to include an Otter export cell in the output notebooks
  instructions: ''             # additional submission instructions to include in the export cell
  pdf: true                    # whether to include a PDF of the notebook in the generated zip file
  filtering: true              # whether the generated PDF should be filtered
  force_save: false            # whether to force-save the notebook with JavaScript (only works in classic notebook)
  run_tests: true              # whether to run student submissions against local tests during export
  files: []                    # a list of other files to include in the student submissions' zip file
seed:                          # intercell seeding configurations
  variable: null               # a variable name to override with the autograder seed during grading
  autograder_value: null       # the value of the autograder seed
  student_value: null          # the value of the student seed
generate: false                # grading configurations to be passed to Otter Generate as an otter_config.json; if false, Otter Generate is disabled
save_environment: false        # whether to save the student's environment in the log
variables: null                # a mapping of variable names to type strings for serializing environments
ignore_modules: []             # a list of modules to ignore variables from during environment serialization
files: []                      # a list of other files to include in the output directories and autograder
autograder_files: []           # a list of other files only to include in the autograder
plugins: []                    # a list of plugin names and configurations
tests:                         # information about the structure and storage of tests
  files: false                 # whether to store tests in separate files, instead of the notebook metadata
  ok_format: true              # whether the test cases are in OK-format (instead of the exception-based format)
  url_prefix: null             # a URL prefix for where test files can be found for student use
show_question_points: false    # whether to add the question point values to the last cell of each question
runs_on: default               # the interpreter this notebook will be run on if different from the default interpreter (one of {'default', 'colab', 'jupyterlite'})
python_version: null           # the version of Python to use in the grading image (must be 3.6+)
```

Configuration for tasks can be set after `# BEGIN QUESTION`.

```shell
name: null        # (required) the path to a requirements.txt file
manual: false     # whether this is a manually-graded question
points: null      # how many points this question is worth; defaults to 1 internally
check_cell: true  # whether to include a check cell after this question (for autograded questions only)
export: false     # whether to force-include this question in the exported PDF
```

Configuration for tests can be set after `# BEGIN TEST`

As an Example, the following code snippet

```python
def square(x):
    y = x * x # SOLUTION NO PROMPT
    return y # SOLUTION

nine = square(3) # SOLUTION
```

would be presented to the student as

```python
def square(x):
    ...

nine = ...
```

Another Example is shown below.<br>
Teacher View:

```python
pi = 3.14
if True:
    # BEGIN SOLUTION
    radius = 3
    area = radius * pi * pi
    # END SOLUTION
    print('A circle with radius', radius, 'has area', area)

def circumference(r):
    # BEGIN SOLUTION NO PROMPT
    return 2 * pi * r
    # END SOLUTION
    """ # BEGIN PROMPT
    # Next, define a circumference function.
    pass
    """; # END PROMPT
```

Students View:

```python
pi = 3.14
if True:
    ...
    print('A circle with radius', radius, 'has area', area)

def circumference(r):
    # Next, define a circumference function.
    pass
```

An example of an notebook that can be autograde can be found in [demo.ipynb](./demo.ipynb).
For further information look [here](https://otter-grader.readthedocs.io/en/latest/otter_assign/v1/notebook_format.html)
