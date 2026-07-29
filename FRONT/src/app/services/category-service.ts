import { HttpClient } from '@angular/common/http';
import { inject, Injectable } from '@angular/core';
import { map } from 'rxjs';
import { CategoryModel, CategoryPayload } from '../models/category-model';

interface ApiResource<T> {
  // Format standard d'une réponse produite par une Resource Laravel.
  data: T;
}

@Injectable({ providedIn: 'root' })
export class CategoryService {
  private readonly http = inject(HttpClient);
  private readonly apiUrl = 'http://localhost:8000/api/categories';

  /** Charge toutes les catégories avec leur nombre de produits. */
  getAll() {
    return this.http
      .get<ApiResource<CategoryModel[]>>(this.apiUrl)
      .pipe(map((response) => response.data));
  }

  /** Crée une nouvelle catégorie. */
  create(category: CategoryPayload) {
    return this.http
      .post<ApiResource<CategoryModel>>(this.apiUrl, category)
      .pipe(map((response) => response.data));
  }

  /** Modifie une catégorie existante. */
  update(id: number, category: CategoryPayload) {
    return this.http
      .put<ApiResource<CategoryModel>>(`${this.apiUrl}/${id}`, category)
      .pipe(map((response) => response.data));
  }

  /** Supprime la catégorie sélectionnée. */
  delete(id: number) {
    return this.http.delete<void>(`${this.apiUrl}/${id}`);
  }
}
