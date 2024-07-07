// Import Vue Router and necessary store modules
import { createRouter, createWebHistory } from 'vue-router';
import { useUserStore } from '@/stores/user.js';
import { useAdminStore } from '@/stores/admin.js';

// Define routes
const routes = [
  // Default layout
  {
    path: '/',
    name: 'DefaultLayout',
    component: () => import('@/views/layouts/DefaultLayout.vue'),
    children: [
      { path: '/', name: 'Home', component: () => import('@/views/HomeView.vue') },
      { path: '/login', name: 'Login', component: () => import('@/views/auth/LoginView.vue') },
      { path: '/register', name: 'Register', component: () => import('@/views/auth/RegisterView.vue') },
      {
        path: '/profile',
        name: 'Profile',
        meta: { requiresAuth: true },
        component: () => import('@/views/user/ProfileView.vue'),
        children: [
          { path: 'info', name: 'Info', component: () => import('@/views/user/InformationView.vue') },
          { path: 'user-books', name: 'UserBooks', component: () => import('@/views/user/UserBooksView.vue') }
        ]
      },
      { path: '/books', name: 'Books', component: () => import('@/views/books/BooksView.vue') },
      { path: '/book/:id', name: 'Book', component: () => import('@/views/books/BookView.vue') },
      { path: '/add-book', name: 'AddBook', meta: { requiresAuth: true }, component: () => import('@/views/books/AddBook.vue') },
      { path: '/test', name: 'Test', component: () => import('@/views/TestView.vue') },
      { path: '/:pathMatch(.*)*', name: 'NotFound', component: () => import('@/views/404View.vue') }
    ]
  },

  // Admin layout
  {
    path: '/admin/login',
    name: 'AdminLogin',
    component: () => import('@/views/admin/auth/AdminLoginView.vue')
  },
  {
    path: '/admin',
    name: 'AdminLayout',
    meta: { requiresAdminAuth: true },
    component: () => import('@/views/layouts/AdminLayout.vue'),
    children: [
      { path: '/admin', name: 'AdminHome', component: () => import('@/views/admin/dashboard/AdminHomeView.vue') },
      { path: 'add-admin', name: 'AddAdmin', component: () => import('@/views/admin/dashboard/admin/AddAdminView.vue') },
      { path: 'admin-lists', name: 'AdminLists', component: () => import('@/views/admin/dashboard/admin/AdminListsView.vue') },
      { path: 'book-lists', name: 'BookLists', component: () => import('@/views/admin/dashboard/BookListsView.vue') },
      { path: 'user-lists', name: 'UserLists', component: () => import('@/views/admin/dashboard/UserListsView.vue') },
    ]
  }
];

// Create router instance
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
});

// Navigation guard to check authentication
router.beforeEach(async (to, from, next) => {
  // Extract `meta` and `name` from the `to` route object
  const { meta, name } = to;

  // Retrieve authentication status for the user and admin
  const { isAuth: isUserAuth } = useUserStore();
  const { isAuth: isAdminAuth } = useAdminStore();

  // Check if authentication is required for the route and user is not authenticated
  if (meta.requiresAuth && !isUserAuth) {
    next('/login'); // Redirect to login page
  }
  // Redirect to home if user is already authenticated and tries to access login or register pages
  else if ((name === 'Login' || name === 'Register') && isUserAuth) {
    next('/'); // Redirect to home page
  }
  // Redirect to login if user tries to access profile page without authentication
  else if (name === 'Profile' && !isUserAuth) {
    next('/login'); // Redirect to login page
  }
  // Check if admin authentication is required for the route and admin is not authenticated
  else if (meta.requiresAdminAuth && !isAdminAuth) {
    next('/admin/login'); // Redirect to admin login page
  }
  // Proceed to the next route if all conditions are met
  else {
    next(); // Proceed to the requested route
  }
});

export default router;
