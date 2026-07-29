import { inject, Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { map } from 'rxjs';
import { ProductModel, ProductPayload } from '../models/product-model';

interface ApiResource<T> {
  // Les API Resources Laravel enveloppent leur résultat dans la clé data.
  data: T;
}

@Injectable({ providedIn: 'root' })
export class ProductService {
  // inject() est l'alternative moderne au constructeur d'injection Angular.
  private http = inject(HttpClient);
  private readonly apiUrl = 'http://localhost:8000/api/products';

  /** Récupère la liste complète des produits. */
  getAll() {
    return this.http
      .get<ApiResource<ProductModel[]>>(this.apiUrl)
      .pipe(map((response) => response.data));
  }

  /** Récupère un produit à partir de son identifiant. */
  getById(id: number) {
    return this.http
      .get<ApiResource<ProductModel>>(`${this.apiUrl}/${id}`)
      .pipe(map((response) => response.data));
  }

  /** Envoie les données du formulaire pour créer un produit. */
  create(product: ProductPayload) {
    return this.http
      .post<ApiResource<ProductModel>>(this.apiUrl, product)
      .pipe(map((response) => response.data));
  }

  /** Remplace les données du produit identifié par id. */
  update(id: number, product: ProductPayload) {
    return this.http
      .put<ApiResource<ProductModel>>(`${this.apiUrl}/${id}`, product)
      .pipe(map((response) => response.data));
  }

  /** Supprime définitivement un produit. */
  delete(id: number) {
    return this.http.delete<void>(`${this.apiUrl}/${id}`);
  }
}
