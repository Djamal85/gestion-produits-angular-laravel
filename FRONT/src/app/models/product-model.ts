import { CategoryModel } from './category-model';

export interface ProductModel {
  id: number;
  name: string;
  price: number;
  description: string | null;
  category_id: number | null;
  category: CategoryModel | null;
}

export interface ProductPayload {
  name: string;
  price: number;
  description: string;
  category_id: number;
}
