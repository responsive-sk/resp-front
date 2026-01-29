# Testing Skeleton.css Integration

## What was done:
✅ Copied `skeleton.css` to `resp-front/public/styles/`
✅ Added `<link>` to `layout/master.php`
✅ Committed changes

## How to Test:

### 1. Start Dev Server
```bash
cd /home/evan/Desktop/02/resp/blog
php -S localhost:8000 -t public
```

### 2. Open Browser
Navigate to: `http://localhost:8000`

### 3. Check DevTools

#### Network Tab (Throttling)
```
1. Open DevTools (F12)
2. Go to Network tab
3. Set throttling: "Slow 3G"
4. Reload page (Ctrl+R)
5. Watch components load
```

**Expected:** You should see placeholder boxes/shimmer before components appear

#### Performance Tab
```
1. Open DevTools (F12)  
2. Go to Performance tab
3. Click Record
4. Reload page
5. Stop recording
6. Look for "Layout Shift" events
```

**Before skeleton.css:** Many red layout shift bars  
**After skeleton.css:** Minimal/no layout shift bars

### 4. Lighthouse Test
```bash
# Install if needed
npm install -g lighthouse

# Run test
lighthouse http://localhost:8000 --view

# Or Chrome DevTools
# 1. F12 → Lighthouse tab
# 2. Click "Analyze page load"
# 3. Check CLS score
```

**Target Scores:**
- CLS: <0.1 (was 0.300) ✅
- LCP: <2.5s
- FCP: <1.8s

### 5. Visual Check

#### Slow connection simulation:
1. Open page with DevTools Network throttling (Slow 3G)
2. You should see:
   - ✅ Header placeholder (80px gray bar)
   - ✅ Hero section placeholder (600px gradient)
   - ✅ Button placeholders (shimmer effect)
   - ✅ Then components "pop in" smoothly

#### Debug Mode:
Uncomment in `skeleton.css` (line ~170):
```css
*:not(:defined) {
    outline: 2px dashed red !important;
}
```
→ Reload → See red outlines on loading components

## Common Issues:

### Issue: skeleton.css not loading (404)
**Fix:**
```bash
# Check file exists
ls -la public/styles/skeleton.css

# If missing, copy again
cp /path/to/blog/public/styles/skeleton.css public/styles/
```

### Issue: No visible change
**Possible reasons:**
1. Components load too fast (good connection)
   → Use Network throttling
2. CSS cached
   → Hard reload (Ctrl+Shift+R)
3. Wrong component names in CSS
   → Check your actual component tag names

### Issue: Components flash/jump
**Fix:** Adjust min-heights in skeleton.css to match actual component heights

## Expected Results:

### Before:
```
Page load:
1. White screen
2. Header appears (jump)
3. Hero section appears (big jump)
4. Buttons appear (small jump)
→ Total CLS: 0.300 ❌
```

### After:
```
Page load:
1. Skeleton screens visible immediately
2. Components hydrate in-place (no jump)
3. Smooth transition
→ Total CLS: <0.1 ✅
```

## Next Steps:

If CLS is still >0.1:
1. Check font loading (might need font-display: optional)
2. Adjust skeleton heights to match real components
3. Consider route-based code splitting (Phase 3)
4. Review images (need width/height attributes)

## Checklist:

- [ ] skeleton.css loads in Network tab
- [ ] Skeleton screens visible on slow connection
- [ ] CLS score improved in Lighthouse
- [ ] No console errors
- [ ] Components load correctly after hydration
- [ ] Responsive (test mobile viewport)
