import { Component, inject, signal } from '@angular/core';
import { FormBuilder, ReactiveFormsModule, Validators } from '@angular/forms';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { ProductService } from '../services/product-service';
import { CategoryModel } from '../models/category-model';
import { CategoryService } from '../services/category-service';

@Component({
  selector: 'app-add-product',
  imports: [ReactiveFormsModule, RouterLink],
  templateUrl: './addProduct.html',
  styleUrl: './product.css',
})
export class AddProduct {
  private readonly formBuilder = inject(FormBuilder);
  private readonly productService = inject(ProductService);
  private readonly categoryService = inject(CategoryService);
  private readonly route = inject(ActivatedRoute);
  private readonly router = inject(Router);

  readonly productId = signal<number | null>(null);
  readonly loading = signal(false);
  readonly error = signal('');
  readonly categories = signal<CategoryModel[]>([]);
  readonly form = this.formBuilder.nonNullable.group({
    name: ['', [Validators.required, Validators.maxLength(100)]],
    price: [0, [Validators.required, Validators.min(0)]],
    description: [''],
    category_id: [0, [Validators.required, Validators.min(1)]],
  });

  ngOnInit(): void {
    this.categoryService.getAll().subscribe({
      next: (categories) => this.categories.set(categories),
      error: () => this.error.set('Impossible de charger les catégories.'),
    });

    const id = Number(this.route.snapshot.paramMap.get('id'));
    if (!id) {
      return;
    }

    this.productId.set(id);
    this.loading.set(true);
    this.productService.getById(id).subscribe({
      next: (product) => {
        this.form.patchValue({
          name: product.name,
          price: product.price,
          description: product.description ?? '',
          category_id: product.category_id ?? 0,
        });
        this.loading.set(false);
      },
      error: () => {
        this.error.set('Impossible de charger ce produit.');
        this.loading.set(false);
      },
    });
  }

  submit(): void {
    if (this.form.invalid) {
      this.form.markAllAsTouched();
      return;
    }

    this.loading.set(true);
    this.error.set('');
    const id = this.productId();
    const request = id
      ? this.productService.update(id, this.form.getRawValue())
      : this.productService.create(this.form.getRawValue());

    request.subscribe({
      next: () => void this.router.navigate(['/product']),
      error: () => {
        this.error.set("L'enregistrement du produit a échoué.");
        this.loading.set(false);
      },
    });
  }
}
