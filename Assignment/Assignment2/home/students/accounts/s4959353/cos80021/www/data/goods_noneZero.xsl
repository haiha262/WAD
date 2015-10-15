<?xml version="1.0" encoding="iso-8859-1"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" />
<xsl:template match="/">
	<div>
		<h3 id="lb">Shopping Catalog</h3>
		<table class="tableCat">
		<tr>
			<th>Item Number</th>
			<th>Name</th>
			<th>Price</th>
			<th>Quantity Available</th>
			<th>Quantity on Hold</th>
			<th>Quantity Sold</th>
		</tr>

			<xsl:for-each select="/items/item[sold &gt; 0]">
				<tr>
					<xsl:variable name="id" select="id"> </xsl:variable>
					
					<td><xsl:value-of select="id" /></td>
					<td><xsl:value-of select="name" /></td>
					<td><xsl:value-of select="price" /></td>
					<td><xsl:value-of select="quantity" /></td>
					<td><xsl:value-of select="holdon" /></td>
					<td><xsl:value-of select="sold" /></td>					
				</tr>				
			</xsl:for-each>
		<tr>
			<td colspan="6" class="title"><input type="button" value="Process" onclick="Process();"/></td>
		</tr>
		</table>
	</div>	
</xsl:template>
</xsl:stylesheet>
