import { Component, signal } from '@angular/core';
import { RouterLink, RouterOutlet } from '@angular/router';
import { Assurance } from './assurance/assurance';
import { Type } from './type/type';
import { Product } from './product/product';
import { AddProduct } from './product/Addproduct';

@Component({
  selector: 'app-root',
  imports: [RouterOutlet, Assurance, Type, Product, AddProduct, RouterLink],
  templateUrl: './app.html',
  styleUrl: './app.css',
})
export class App {
  protected readonly title = signal('gestion-front-iage');
}
