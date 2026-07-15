import { inject, Service } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { ProductModel } from '../models/product-model';

@Service()
export class ProductService {

  private http = inject(HttpClient);


  getAll(){
    return   this.http.get<ProductModel[]>(`http://localhost:8000/api/products`);
  }

  delete(id : number) {
    return this.http.delete(`http://localhost:8000/api/products/${id}`);
  }

}
