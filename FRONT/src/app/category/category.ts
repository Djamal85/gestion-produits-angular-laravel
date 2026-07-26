import { Component, inject, signal } from '@angular/core';
import { FormBuilder, ReactiveFormsModule, Validators } from '@angular/forms';
import { CategoryModel } from '../models/category-model';
import { CategoryService } from '../services/category-service';

@Component({
  selector: 'app-category',
  imports: [ReactiveFormsModule],
  templateUrl: './category.html',
  styleUrl: './category.css',
})
export class Category {
  private readonly formBuilder = inject(FormBuilder);
  private readonly categoryService = inject(CategoryService);

  readonly categories = signal<CategoryModel[]>([]);
  readonly editingId = signal<number | null>(null);
  readonly loading = signal(false);
  readonly error = signal('');
  readonly form = this.formBuilder.nonNullable.group({
    name: ['', [Validators.required, Validators.maxLength(100)]],
    description: [''],
  });

  ngOnInit(): void {
    this.loadCategories();
  }

  loadCategories(): void {
    this.loading.set(true);
    this.categoryService.getAll().subscribe({
      next: (categories) => {
        this.categories.set(categories);
        this.loading.set(false);
      },
      error: () => {
        this.error.set('Impossible de charger les catégories.');
        this.loading.set(false);
      },
    });
  }

  edit(category: CategoryModel): void {
    this.editingId.set(category.id);
    this.form.setValue({
      name: category.name,
      description: category.description ?? '',
    });
  }

  cancelEdit(): void {
    this.editingId.set(null);
    this.form.reset();
  }

  submit(): void {
    if (this.form.invalid) {
      this.form.markAllAsTouched();
      return;
    }

    this.loading.set(true);
    this.error.set('');
    const id = this.editingId();
    const request = id
      ? this.categoryService.update(id, this.form.getRawValue())
      : this.categoryService.create(this.form.getRawValue());

    request.subscribe({
      next: () => {
        this.cancelEdit();
        this.loadCategories();
      },
      error: () => {
        this.error.set("L'enregistrement de la catégorie a échoué.");
        this.loading.set(false);
      },
    });
  }

  delete(category: CategoryModel): void {
    if (!confirm(`Supprimer la catégorie « ${category.name} » ?`)) {
      return;
    }

    this.categoryService.delete(category.id).subscribe({
      next: () => this.loadCategories(),
      error: () => this.error.set('La suppression a échoué.'),
    });
  }
}
