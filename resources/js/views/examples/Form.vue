<template>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="mb-7" id="intro">
            <h1 class="mb-2">Forms</h1>
            <p class="mb-0 lead text-dark">Examples and usage guidelines for form control styles, layout options, and custom components for creating a wide variety of forms. </p>
        </div>
        </div>
    </div>
    <!-- basic-forms -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div id="basicForm" class="mb-4">
            <h2>Basic Froms</h2>
            <p>Textual form controls—like <code>&lt;input&gt;</code>s, <code>&lt;select&gt;</code>s, and <code>&lt;textarea&gt;</code>s—are styled with the <code>.form-control</code> class. Included are styles for general appearance, focus state, sizing, and more. </p>
        </div>
        <!-- Card -->
        <div class="card">
            <ul class="nav nav-line-bottom " id="pills-tab-basic-forms" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-basic-forms-design-tab" data-bs-toggle="pill" href="#pills-basic-forms-design" role="tab" aria-controls="pills-basic-forms-design" aria-selected="true">Design</a>
            </li>
            </ul>
            <!-- Tab content -->
            <div class="tab-content p-4" id="pills-tabContent-basic-forms">
            <div class="tab-pane tab-example-design fade show active" id="pills-basic-forms-design" role="tabpanel" aria-labelledby="pills-basic-forms-design-tab">
                <form>
                <!-- Input -->
                <div class="mb-3">
                    <label class="form-label" for="textInput">Text</label>
                    <input type="text" id="textInput" class="form-control" placeholder="Input Text">
                </div>
                <!-- Password -->
                <div class="mb-3">
                    <label class="form-label" for="passwordInput">Password</label>
                    <input type="password" id="passwordInput" class="form-control" value="********">
                </div>
                <!-- Helper Text -->
                <div class="mb-3">
                    <label class="form-label">Helper text</label>
                    <input type="password" class="form-control" value="**********">
                    <span class="text-muted ">Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.</span>
                </div>
                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label" for="emailInput">Email</label>
                    <input type="email" id="emailInput" class="form-control" placeholder="name@example.com">
                </div>
                <!-- Select Option -->
                <div class="mb-3">
                    <label class="form-label" for="selectOne">Select <span class="text-secondary">(Optional)</span>
                    </label>
                    <select id="selectOne" class="form-select">
                    <option>Choose an option</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    </select>
                </div>
                <!-- Mulitple Select Option -->
                <div class="mb-3">
                    <label class="form-label" for="selectTwo">Multiple select</label>
                    <select id="selectTwo" class="form-select" size="3" multiple="">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    </select>
                </div>
                <!-- Text Area -->
                <div class="mb-3">
                    <label class="form-label" for="textareaInput">Textarea</label>
                    <textarea id="textareaInput" class="form-control" placeholder="Textarea field" rows="4"></textarea>
                </div>
                </form>
            </div>
            </div>
        </div>
        </div>
    </div>
    <!-- basic-forms -->
    <hr class="my-10">
    <!-- sizing -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div id="sizing" class="mb-4">
            <h2>Sizing</h2>
            <p>Set heights using classes like <code class="highlighter-rouge">.form-control-lg</code> and <code class="highlighter-rouge">.form-control-sm</code>. </p>
        </div>
        <!-- Card -->
        <div class="card">
            <ul class="nav nav-line-bottom " id="pills-tab-sizing" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-sizing-design-tab" data-bs-toggle="pill" href="#pills-sizing-design" role="tab" aria-controls="pills-sizing-design" aria-selected="true">Design</a>
            </li>
            </ul>
            <!-- Tab content -->
            <div class="tab-content p-4" id="pills-tabContent-sizing">
            <div class="tab-pane tab-example-design fade show active" id="pills-sizing-design" role="tabpanel" aria-labelledby="pills-sizing-design-tab">
                <div class="mb-3">
                <input type="text" class="form-control form-control-lg" placeholder="Large input">
                </div>
                <div class="mb-3">
                <input type="text" class="form-control" placeholder="Normal input">
                </div>
                <div class="mb-3">
                <input type="text" class="form-control form-control-sm" placeholder="Small input">
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    <!-- sizing -->
    <hr class="my-10">
    <!-- select-sizes -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="mb-4" id="select-menu">
            <h2>Select Menu</h2>
            <p>Custom <code>&lt;select&gt;</code> menus need only a custom class, <code>.form-select</code> to trigger the custom styles. Custom styles are limited to the <code>&lt;select&gt;</code>’s initial appearance and cannot modify the <code>&lt;option&gt;</code>s due to browser limitations. </p>
        </div>
        <!-- Card -->
        <div class="card">
            <ul class="nav nav-line-bottom " id="pills-tab-select-menu" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-select-menu-design-tab" data-bs-toggle="pill" href="#pills-select-menu-design" role="tab" aria-controls="pills-select-menu-design" aria-selected="true">Design</a>
            </li>
            </ul>
            <!-- Tab content -->
            <div class="tab-content p-4" id="pills-tabContent-select-menu">
            <div class="tab-pane tab-example-design fade show active" id="pills-select-menu-design" role="tabpanel" aria-labelledby="pills-select-menu-design-tab">
                <select class="form-select">
                <option selected>Open this select menu</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
                </select>
            </div>
            </div>
        </div>
        <div class="mt-4">
            <p>You may also choose from small and large custom selects to match our similarly sized text inputs. </p>
        </div>
        <!-- Card -->
        <div class="card">
            <ul class="nav nav-line-bottom " id="pills-tab-select-sizes" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-select-sizes-design-tab" data-bs-toggle="pill" href="#pills-select-sizes-design" role="tab" aria-controls="pills-select-sizes-design" aria-selected="true">Design</a>
            </li>
            </ul>
            <!-- Content -->
            <div class="tab-content p-4" id="pills-tabContent-select-sizes">
            <div class="tab-pane tab-example-design fade show active" id="pills-select-sizes-design" role="tabpanel" aria-labelledby="pills-select-sizes-design-tab">
                <select class="form-select form-select-lg  mb-3">
                <option selected>Open this select menu</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
                </select>
                <select class="form-select form-select-sm">
                <option selected>Open this select menu</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
                </select>
            </div>
            </div>
        </div>
        </div>
    </div>
    <!-- select-sizes -->
    <hr class="my-10">
    <!-- validation -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div id="validation" class="mb-4">
            <h2>Validation states</h2>
            <p>It provides valuable, actionable feedback to your users with HTML5 form validation. </p>
        </div>
        <!-- Card -->
        <div class="card mb-4">
            <ul class="nav nav-line-bottom " id="pills-tab-validation" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-validation-design-tab" data-bs-toggle="pill" href="#pills-validation-design" role="tab" aria-controls="pills-validation-design" aria-selected="true">Design</a>
            </li>
            </ul>
            <!-- Tab content -->
            <div class="tab-content p-4" id="pills-tabContent-validation">
            <div class="tab-pane tab-example-design fade show active" id="pills-validation-design" role="tabpanel" aria-labelledby="pills-validation-design-tab">
                <form class="row g-3 needs-validation" novalidate>
                <div class="col-md-4">
                    <label for="validationCustom01" class="form-label">First name</label>
                    <input type="text" class="form-control" id="validationCustom01" value="Mark" required>
                    <div class="valid-feedback"> Looks good! </div>
                </div>
                <div class="col-md-4">
                    <label for="validationCustom02" class="form-label">Last name</label>
                    <input type="text" class="form-control" id="validationCustom02" value="Otto" required>
                    <div class="valid-feedback"> Looks good! </div>
                </div>
                <div class="col-md-4">
                    <label for="validationCustomUsername" class="form-label">Username</label>
                    <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                    <input type="text" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
                    <div class="invalid-feedback"> Please choose a username. </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="validationCustom03" class="form-label">City</label>
                    <input type="text" class="form-control" id="validationCustom03" required>
                    <div class="invalid-feedback"> Please provide a valid city. </div>
                </div>
                <div class="col-md-3">
                    <label for="validationCustom04" class="form-label">State</label>
                    <select class="form-select" id="validationCustom04" required>
                    <option selected disabled value="">Choose...</option>
                    <option>...</option>
                    </select>
                    <div class="invalid-feedback"> Please select a valid state. </div>
                </div>
                <div class="col-md-3">
                    <label for="validationCustom05" class="form-label">Zip</label>
                    <input type="text" class="form-control" id="validationCustom05" required>
                    <div class="invalid-feedback"> Please provide a valid zip. </div>
                </div>
                <div class="col-12">
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                    <label class="form-check-label" for="invalidCheck"> Agree to terms and conditions </label>
                    <div class="invalid-feedback"> You must agree before submitting. </div>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Submit form</button>
                </div>
                </form>
            </div>
            </div>
        </div>
        </div>
    </div>
    <!-- validation -->
</template>
