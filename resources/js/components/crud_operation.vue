<template>
 <div class="mx-auto  border-gray-950 border-2 
            bg-gray-300 rounded w-[450px] 
            p-6 my-6">

  <h1 class=" text-center text-xl font-semibold 
             text-blue-600 italic mb-4">
    Vue CRUD
  </h1>

  <!-- Form -->
  <div class="space-y-4">
    <p id="message" v-if="message" class="text-gray-950">{{message}}</p>

    <div>
      <label class="block mb-1 text-gray-950 font-semibold italic">
        Name:
      </label>
      <input type="text"
        class="w-full bg-gray-200 border border-gray-950 rounded p-2"
        v-model="form.name"
        placeholder="Enter your name" />
    </div>

    <div>
      <label class="block mb-1 text-gray-950 font-semibold italic">
        Email:
      </label>
      <input type="text"
        class="w-full bg-gray-200 border border-gray-950 rounded p-2"
        v-model="form.email"
        placeholder="Enter your Email" />
    </div>

    <div>
      <label class="block mb-1 text-gray-950 font-semibold italic">
        Phone:
      </label>
      <input type="text"
        class="w-full bg-gray-200 border border-gray-950 rounded p-2"
        v-model="form.phone"
        placeholder="Enter your number" />
    </div>

    <div>
      <label class="block mb-1 text-gray-950 font-semibold italic">
        Place:
      </label>
      <input type="text"
        class="w-full bg-gray-200 border border-gray-950 rounded p-2"
        v-model="form.place"
        placeholder="Enter your Place" />
    </div>
    <div>
      <label class="block mb-1 text-gray-950 font-semibold italic">
        state:
      </label>
      <label class="flex gap-3 items-center text-base">
      <input type="radio" value="tamilnadu"
        class="scale-150"
        v-model="form.state"/>Tamilnadu
      </label>
      <label class="flex gap-3 items-center text-base">
          <input type="radio" value="pondy"
        class="scale-150"
        v-model="form.state"/>Pondycherry
        </label>
    </div>
    <div class="flex items-center">
  <label class="block mb-1 text-gray-950 font-semibold italic">
    Qualification:
  </label>

  <input type="checkbox" value="10th" v-model="form.qualification" /> 10th
  <input type="checkbox" value="bsc" v-model="form.qualification" /> B.Sc (CS)
  <input type="checkbox" value="be" v-model="form.qualification" /> B.E (CS)
</div>


    <button
      @click="saveUser"
      class="w-full bg-lilac-dark-12 border rounded p-2">
      {{ editId ? "Update" : "Add" }}
    </button>

  </div>
</div>

    
    <hr />
   <div class="grid justify-center items-center gap-4 mt-6">
    <!-- Table -->
     <button @click="deletemultiple" class="bg-lilac-dark-12 w-[130px]">Delete multiple</button>
    <table border="1" cellpadding="10" class="mb-4 border-2 border-gray-950 w-fit p-4 rounded-md">
      <thead class="bg-gray-400">
        <tr>
          <th class="border p-2">Select</th>
          <th class="border p-2">ID</th>
          <th class="border p-2">Name</th>
          <th class="border p-2">Email</th>
          <th class="border p-2">Phone</th>
          <th class="border p-2">Place</th>
          <th class="border p-2">state</th>
          <th class="border p-2">qualification</th>
          <th class="border p-2">Edit</th>
          <th class="border p-2">Delete</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td class="border p-2"><input type="checkbox" :value="user.id" v-model="form.selectedids"></td>
          <td class="border p-2">{{ user.id }}</td>
          <td class="border p-2">{{ user.name }}</td>
          <td class="border p-2">{{ user.email }}</td>
          <td class="border p-2">{{ user.phone }}</td>
          <td class="border p-2">{{ user.place }}</td>
          <td class="border p-2">{{ user.state }}</td>
          <td class="border p-2">{{ user.qualification }}</td>

          
          <td class="border p-2">
            <button @click="editUser(user)">Edit</button>
            </td>
            <td class="border p-2">
            <button @click="deleteUser(user.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
</div>
 
</template>

<script>
import axios from "axios";
axios.defaults.baseURL = 'http://localhost/crud_vue_axios/public';

export default {
  name: "crud_operation",

  data() {
    return {
      users: [],
      form: {
        name: "",
        email: "",
        phone: "",
        place: "",
        state: "",
        qualification: [],
        selectedids: [],
        
      },
      editId: null,
      message: ""
    };
  },

  mounted() {
    this.getUsers();
  },

  methods: {

    // Fetch All Users
    getUsers() {
      axios.get("/users")
        .then(response => {
          this.users = response.data;
        });
    },

    // Add or Update
    saveUser() {
      if (!this.form.name || !this.form.email || !this.form.phone || !this.form.place 
      || !this.form.state  || !this.form.qualification) {
       
        this.message = ("All fields required");
        return;
      }

      if (this.editId) {
        // Update
        axios.put(`/users/${this.editId}`, this.form)
          .then((response) => {
            this.message = response.data.message;
            this.resetForm();
            this.getUsers();
          });
      } else {
        // Insert
        axios.post("/users", this.form)
          .then((response) => {
           this.message = response.data.message; // its for creating show normal message for after complete any method

            this.resetForm();
            this.getUsers();
            
          });
          
      }
    },

    // Edit
    editUser(user) {
      this.form = { ...user };
      this.editId = user.id;
      this.form.qualification = user.qualification  //When loading data for edit, convert string to array.
      ? user.qualification.split(',')
      : [];
      
    },

    // Delete
    deleteUser(id) {
      if (confirm("Are you sure?")) {
        axios.delete(`/users/${id}`)
          .then((response) => {
            this.message = response.data.message;
            this.getUsers();
          });
      }
    },

    // Delete multiple
    deletemultiple() {
      if (this.form.selectedids.length === 0) {
        alert("Please select at least one user to delete.");
        return;
      }

      if (confirm("Are you sure you want to delete the selected users?")) {
        axios.post("/users/delete-multiple", { ids: this.form.selectedids })
          .then((response) => {
            this.message = response.data.message;
            this.form.selectedids = []; // Clear selected IDs after deletion
            this.getUsers();
          });
      }
    },
    
    // Reset
    resetForm() {
      this.form = {
        name: "",
        email: "",
        phone: "",
        place: "",
        state: "",
        qualification: [],
        
    
        
      };
      this.editId = null;
    }

  }
};
</script>




<!-- 9️⃣ Overall Flow

Page loads

mounted() runs

getUsers() fetches data

Users shown in table

User fills form

Click Add / Update

Axios sends data to Laravel

Database updates

Table refreshes

🎯 Final Summary

This component demonstrates:

Vue Options API

Two-way binding

Lifecycle hook

REST API usage

Conditional logic

Array handling (checkbox)

CRUD operations

Multiple delete logic -->
