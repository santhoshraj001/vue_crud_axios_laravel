<template>
  <div>
    <h2 class="rnup-text-xl rnup-ml-[25%] rnup-font-bold rnup-text-gray-800">
      Simple Vue CRUD
    </h2>

    <!-- Input Section -->

    <label class="rnup-block rnup-mt-4 rnup-text-gray-950">
      Name:
      <input
        type="text"
        class="rnup-border rnup-border-gray-950 rnup-p-2 rnup-m-2 rnup-bg-gray-200 rnup-rounded-md"
        v-model="newUser.name"
        placeholder="Enter your name"
      />
    </label>

    <label class="rnup-block rnup-mt-4 rnup-text-gray-950">
      Email:
      <input
        type="text"
        class="rnup-border rnup-border-gray-950 rnup-p-2 rnup-m-2 rnup-bg-gray-200 rnup-rounded-md"
        v-model="newUser.email"
        placeholder="Enter email address"
      />
    </label>

    <label class="rnup-block rnup-mt-4 rnup-text-gray-950">
      Phone:
      <input
        type="text"
        class="rnup-border rnup-border-gray-950 rnup-p-2 rnup-m-2 rnup-bg-gray-200 rnup-rounded-md"
        v-model="newUser.phone"
        placeholder="Enter phone number"
      />
    </label>

    <label class="rnup-block rnup-mt-4 rnup-text-gray-950">
      Place:
      <input
        type="text"
        class="rnup-border rnup-border-gray-950 rnup-p-2 rnup-m-2 rnup-bg-gray-200 rnup-rounded-md"
        v-model="newUser.address"
        placeholder="Enter your place"
      />
    </label>

    <button @click="addUser" class="btn">
      {{ editIndex === null ? "Add" : "Update" }}
    </button>

    <p v-if="users.length === 0">No users added yet</p>

    <hr />

    <!-- User List -->
    <ul>
      <li v-for="(user, index) in users" :key="index">
        <strong>{{ user.name }}</strong> |
        {{ user.email }} |
        {{ user.phone }} |
        {{ user.address }}

        <button @click="editUser(index)" class="btnedit">
          Edit
        </button>
        <button @click="deleteUser(index)" class="btndelete">
          Delete
        </button>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "CrudComponent",

  data() {
    return {
      newUser: {
        name: "",
        email: "",
        phone: "",
        address: "",
      },
      users: [],
      editIndex: null,
    };
  },

  methods: {
    addUser() {
      // Basic validation
      if (
        this.newUser.name.trim() === "" ||
        this.newUser.email.trim() === "" ||
        this.newUser.phone.trim() === "" ||
        this.newUser.address.trim() === ""
      ) {
        alert("All fields are required!");
        return;
      }

      if (this.editIndex === null) {
        // Add (push copy)
        this.users.push({ ...this.newUser });
      } else {
        // Update
        this.users[this.editIndex] = { ...this.newUser };
        this.editIndex = null;
      }

      // Reset form
      this.newUser = {
        name: "",
        email: "",
        phone: "",
        address: "",
      };
    },

    editUser(index) {
      this.newUser = { ...this.users[index] };
      this.editIndex = index;
    },

    deleteUser(index) {
      this.users.splice(index, 1);
    },
  },
};
</script>

<style scoped>
button {
  margin-left: 5px;
}

.btn {
  padding: 5px 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.btnedit {
  padding: 5px 10px;
  background-color: #28a745;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.btndelete {
  padding: 5px 10px;
  background-color: #dc3545;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
</style>
