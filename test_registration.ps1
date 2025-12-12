
# Get fresh CSRF token
$registerPageResponse = Invoke-WebRequest -Uri "http://localhost:8000/register" -SessionVariable "testSession"
$csrfTokenMatch = $registerPageResponse.Content | Select-String -Pattern 'name="_token"\s+value="([^"]+)"'
$csrfToken = $csrfTokenMatch.Matches[0].Groups[1].Value
Write-Host "CSRF Token: $csrfToken" -ForegroundColor Green

# Create form body
$newEmail = "newuser$(Get-Random)@test.com"
$formBody = @{
    "full_name" = "Test Registration User"
    "email" = $newEmail
    "phone" = "08123456789"
    "address" = "Jalan Test"
    "password" = "TestPass123"
    "password_confirmation" = "TestPass123"
    "_token" = $csrfToken
}

Write-Host "Submitting form with email: $newEmail" -ForegroundColor Yellow

try {
    $registerResponse = Invoke-WebRequest -Uri "http://localhost:8000/register" `
        -Method POST `
        -Body $formBody `
        -WebSession $testSession `
        -MaximumRedirection 0 `
        -ErrorAction SilentlyContinue

    Write-Host "Response Status: $($registerResponse.StatusCode)" -ForegroundColor Green
    Write-Host "Response Headers: " -ForegroundColor Yellow
    $registerResponse.Headers | Format-Table -AutoSize
    
    # Check if there's a Location header (redirect)
    if ($registerResponse.Headers['Location']) {
        Write-Host "Redirect Location: $($registerResponse.Headers['Location'])" -ForegroundColor Cyan
    }
} catch {
    $response = $_.Exception.Response
    Write-Host "Error Status Code: $($response.StatusCode)" -ForegroundColor Red
    
    if ($response.StatusCode -eq [System.Net.HttpStatusCode]::Found) {
        Write-Host "Got redirect (302), checking location..." -ForegroundColor Cyan
        $response.Headers | Format-Table -AutoSize
    }
}
