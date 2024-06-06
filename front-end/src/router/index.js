import { createRouter, createWebHistory } from 'vue-router'
import { useUserStore } from '@/stores/user.js'

// Define routes
const routes = [
  {
    path: '/',
    name: 'Home',
    component: () => import('@/views/HomeView.vue')
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('@/views/auth/LoginView.vue')
  },
  {
    path: '/register',
    name: 'Register',
    component: () => import('@/views/auth/RegisterView.vue')
  },
  {
    path: '/profile',
    name: 'Profile',
    meta: { requiresAuth: true },
    component: () => import('@/views/user/ProfileView.vue'),
    children: [

      {
        path: 'info',
        name: 'Info',
        component: () => import('@/views/user/InformationView.vue')
      },
      {
        path: 'user-books',
        name: 'UserBooks',
        component: () => import('@/views/user/UserBooksView.vue')
      }


    ]
  }
  ,
  {
    path: '/books',
    name: 'Books',
    component: () => import('@/views/books/BooksView.vue')
  },
  {
    path: '/book/:id',
    name: 'Book',
    component: () => import('@/views/books/BookView.vue')
  },
  {
    path: '/add-book',
    name: 'AddBook',
    meta: { requiresAuth: true }, // Metafield to indicate authentication requirement
    component: () => import('@/views/books/AddBook.vue')
  },
  {
    path: '/test',
    name: 'Test',
    component: () => import('@/views/TestView.vue')
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: ()=>import('@/views/404View.vue')
  },
]

// Create router instance
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

// Navigation guard to check authentication
router.beforeEach(async (to, from, next) => {
  const user = useUserStore()

  // Redirect to login if route requires authentication and user is not authenticated
  if (to.meta.requiresAuth && !user.isAuth) {
    next('/login')
  }
  // Redirect to home if user is already authenticated and tries to access login or register pages
  else if ((to.name === 'Login' || to.name === 'Register') && user.isAuth) {
    next('/')
  } else if (to.name === 'Profile' && !user.isAuth) {
    next('/login')
  }
  // Otherwise, proceed with navigation
  else {
    next()
  }

})

export default router
