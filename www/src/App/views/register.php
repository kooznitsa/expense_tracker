<?php include $this->resolve("partials/_header.php"); ?>

<section
    class="max-w-2xl mx-auto mt-12 p-4 bg-white shadow-md border border-gray-200 rounded"
>
    <form method="POST" class="grid grid-cols-1 gap-6">
        <?php include $this->resolve("partials/_csrf.php"); ?>
        <!-- Email -->
        <label class="block">
            <span class="text-gray-700">Email address</span>
            <input
                value="<?php echo e($oldFormData['email'] ?? ''); ?>"
                name="email"
                type="email"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                placeholder="john@example.com"
            />
            <?php
            $key = "email";
            include $this->resolve("partials/_error.php");
            ?>
        </label>
        <!-- Age -->
        <label class="block">
            <span class="text-gray-700">Age</span>
            <input
                value="<?php echo e($oldFormData['age'] ?? ''); ?>"
                name="age"
                type="number"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                placeholder=""
            />
            <?php
            $key = "age";
            include $this->resolve("partials/_error.php");
            ?>
        </label>
        <!-- Country -->
        <label class="block">
            <span class="text-gray-700">Country</span>
            <select
                name="country"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            >
                <option value="USA">USA</option>
                <option value="Canada" <?php echo $oldFormData['country'] === 'Canada' ? 'selected': ''; ?>>Canada</option>
                <option value="Mexico" <?php echo $oldFormData['country'] === 'Mexico' ? 'selected': ''; ?> >Mexico</option>
            </select>
            <?php
            $key = "country";
            include $this->resolve("partials/_error.php");
            ?>
        </label>
        <!-- Social Media URL -->
        <label class="block">
            <span class="text-gray-700">Social Media URL</span>
            <input
                value="<?php echo e($oldFormData['socialMediaURL'] ?? ''); ?>"
                name="socialMediaURL"
                type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                placeholder=""
            />
            <?php
            $key = "socialMediaURL";
            include $this->resolve("partials/_error.php");
            ?>
        </label>
        <!-- Password -->
        <label class="block">
            <span class="text-gray-700">Password</span>
            <input
                name="password"
                type="password"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                placeholder=""
            />
            <?php
            $key = "password";
            include $this->resolve("partials/_error.php");
            ?>
        </label>
        <!-- Confirm Password -->
        <label class="block">
            <span class="text-gray-700">Confirm Password</span>
            <input
                name="confirmPassword"
                type="password"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                placeholder=""
            />
            <?php
            $key = "confirmPassword";
            include $this->resolve("partials/_error.php");
            ?>
        </label>
        <!-- Terms of Service -->
        <div class="block">
            <div class="mt-2">
                <div>
                    <label class="inline-flex items-center">
                        <input
                           <?php echo $oldFormData['tos'] ?? false ? 'checked' : ''; ?>
                            name="tos"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-offset-0 focus:ring-indigo-200 focus:ring-opacity-50"
                            type="checkbox"
                        />
                        <span class="ml-2">I accept the terms of service.</span>
                    </label>
                    <?php
                    $key = "tos";
                    include $this->resolve("partials/_error.php");
                    ?>
                </div>
            </div>
        </div>
        <button
            type="submit"
            class="block w-full py-2 bg-indigo-600 text-white rounded"
        >
            Submit
        </button>
    </form>
</section>

<?php include $this->resolve("partials/_footer.php"); ?>
