  <form
      hx-put="{{ route('admin.users.update', $user) }}"
      hx-indicator="#spinner"
      id="modal-content"
  >
      <x-modal.header>Edit User</x-modal.header>
      <x-modal.body>
          <x-form-input
              label="Name"
              name="name"
              :value="$user->name"
          />
          <x-form-input
              label="Email Address"
              name="email"
              :value="$user->email"
          />
          <x-form-input-group>
              <x-form-select
                  label="University Start Year"
                  name="uni_start_year"
                  between="2000,current"
                  :value="$user->uni_start_year"
              />
              <x-form-select
                  label="University Finish Year"
                  name="uni_finish_year"
                  between="2000,current"
                  :value="$user->uni_finish_year"
              />
          </x-form-input-group>
      </x-modal.body>
      <x-modal.footer>
          <x-modal.button variant="secondary" data-hide-modal="true">Cancel</x-modal.button>
          <x-modal.button type="submit">Edit User</x-modal.button>
      </x-modal.footer>
  </form>
