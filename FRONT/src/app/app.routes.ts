import { Routes } from '@angular/router';
import { Product } from './product/product';
import { AddProduct } from './product/Addproduct';
import { Category } from './category/category';
// import { Login } from './auth/login';
// import { Register } from './auth/register';
// import { authGuard } from './services/auth-guard';

export const routes: Routes = [
  // La racine de l'application redirige vers la liste des produits.
  { path: '', redirectTo: 'product', pathMatch: 'full' },
  // Authentification temporairement désactivée :
  // { path: 'login', component: Login },
  // { path: 'register', component: Register },
  // { path: 'product', component: Product, canActivate: [authGuard] },
  // { path: 'addProduct', component: AddProduct, canActivate: [authGuard] },
  // { path: 'editProduct/:id', component: AddProduct, canActivate: [authGuard] },

  // Routes publiques actuellement utilisées.
  { path: 'product', component: Product },

  // Le même composant sert à créer et modifier un produit.
  // La présence du paramètre :id active le mode modification.
  { path: 'addProduct', component: AddProduct },
  { path: 'editProduct/:id', component: AddProduct },

  // La gestion des catégories regroupe liste, ajout et modification.
  { path: 'categories', component: Category },

  // Toute URL inconnue ramène vers la page principale.
  { path: '**', redirectTo: 'product' },
];
