import { inject, Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { map } from 'rxjs';
import { ProductModel, ProductPayload } from '../models/product-model';

interface ApiResource<T> {
  data: T;
}

@Injectable({ providedIn: 'root' })
export class ProductService {
  private http = inject(HttpClient);
  private readonly apiUrl = 'http://localhost:8000/api/products';

  getAll() {
    return this.http
      .get<ApiResource<ProductModel[]>>(this.apiUrl)
      .pipe(map((response) => response.data));
  }

  getById(id: number) {
    return this.http
      .get<ApiResource<ProductModel>>(`${this.apiUrl}/${id}`)
      .pipe(map((response) => response.data));
  }

  create(product: ProductPayload) {
    return this.http
      .post<ApiResource<ProductModel>>(this.apiUrl, product)
      .pipe(map((response) => response.data));
  }

  update(id: number, product: ProductPayload) {
    return this.http
      .put<ApiResource<ProductModel>>(`${this.apiUrl}/${id}`, product)
      .pipe(map((response) => response.data));
  }

  delete(id: number) {
    return this.http.delete<void>(`${this.apiUrl}/${id}`);
  }
}
