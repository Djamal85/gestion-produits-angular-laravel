import { Component, inject, signal } from '@angular/core';
import { ProductModel } from '../models/product-model';
import { ProductService } from '../services/product-service';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-product',
  imports: [RouterLink],
  templateUrl: './product.html',
  styleUrl: './product.css',
})
export class Product {
  // Les signals mettent automatiquement le template à jour quand leur valeur change.
  readonly tabProduct = signal<ProductModel[]>([]);
  readonly loading = signal(true);
  readonly error = signal('');
  private readonly productService = inject(ProductService);

  ngOnInit() {
    // Le chargement démarre dès l'affichage du composant.
    this.getAll();
  }

  getAll() {
    // Réinitialise l'état visuel avant chaque appel à l'API.
    this.loading.set(true);
    this.error.set('');
    this.productService.getAll().subscribe({
      next: (products) => {
        this.tabProduct.set(products);
        this.loading.set(false);
      },
      error: () => {
        this.error.set('Impossible de charger les produits.');
        this.loading.set(false);
      },
    });
  }

  delete(id: number): void {
    // La confirmation évite une suppression accidentelle.
    if (!confirm('Voulez-vous vraiment supprimer ce produit ?')) {
      return;
    }
    this.productService.delete(id).subscribe({
      next: () => this.getAll(),
      error: () => this.error.set('La suppression a échoué.'),
    });
  }
}
