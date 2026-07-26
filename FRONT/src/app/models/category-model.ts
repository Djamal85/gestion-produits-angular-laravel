export interface CategoryModel {
  id: number;
  name: string;
  description: string | null;
  products_count?: number;
}

export interface CategoryPayload {
  name: string;
  description: string;
}
