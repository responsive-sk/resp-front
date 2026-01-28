export class Container {
  constructor() { this._services = new Map(); }
  register(name, factory) { this._services.set(name, factory); }
  get(name) { 
    const factory = this._services.get(name);
    if (!factory) throw new Error(`Service '${name}' not found`);
    return factory(this);
  }
}
